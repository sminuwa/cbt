<?php

namespace App\Http\Controllers\Admin\Authoring;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\AnsweroptionsTemp;
use App\Models\QuestionBank;
use App\Models\QuestionBankTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Show the question authoring interface
     */
    public function index()
    {
        return view('pages.admin.questions.questions-authoring');
    }

    /**
     * Process submitted questions from authoring interface
     */
    public function store(Request $request)
    {
        $this->clearTemps(request('subject_id'), request('topic_id'));

        // Handle file upload or text content
        $content = '';
        
        if ($request->hasFile('question_file')) {
            // Validate file upload
            $request->validate([
                'question_file' => 'required|file|mimes:txt,doc,docx|max:5120', // 5MB max
            ]);
            
            $file = $request->file('question_file');
            $content = $this->extractContentFromFile($file);
            
            if (empty($content)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not extract content from the uploaded file. Please check the file format.'
                ], 400);
            }
        } else {
            // Use text editor content
            $content = $request->input('content', '');
        }

        if (empty(trim($content))) {
            return response()->json([
                'success' => false,
                'message' => 'No content provided. Please enter questions or upload a file.'
            ], 400);
        }

        $questions = Helper::extractQuestions($content);

        // Initialize statistics
        $stats = [
            'total_questions' => count($questions),
            'simple' => 0,
            'moderate' => 0,
            'difficult' => 0,
            'total_options' => 0,
            'questions_with_correct_answers' => 0,
            'questions_without_correct_answers' => 0,
            'empty_questions' => 0,
            'questions_with_insufficient_options' => 0,
            'duplicates_in_batch' => 0,
            'duplicates_with_existing' => 0,
            'processing_errors' => [],
        ];

        // Early return if no questions found
        if (empty($questions)) {
            $stats['total_questions'] = 0;
            session(['question_stats' => $stats]);
            return ['url' => route('admin.authoring.review', [request('subject_id'), request('topic_id')])];
        }

        // Prepare bulk insert data for questions and collect statistics
        $questionData = [];
        $now = now();
        $userId = Auth::user()->id;
        $validQuestions = [];

        foreach ($questions as $index => $question) {
            // Track difficulty levels
            switch ($question->difficulty) {
                case 'S':
                    $stats['simple']++;
                    break;
                case 'M':
                    $stats['moderate']++;
                    break;
                case 'D':
                    $stats['difficult']++;
                    break;
            }

            // Validate question
            $errors = $this->validateQuestion($question, $index + 1);
            if (!empty($errors)) {
                $stats['processing_errors'] = array_merge($stats['processing_errors'], $errors);
                continue;
            }

            // Check if question has text
            if (empty(trim($question->text))) {
                $stats['empty_questions']++;
                $stats['processing_errors'][] = "Question " . ($index + 1) . ": Empty question text";
                continue;
            }

            // Check options
            $hasCorrectAnswer = false;
            $optionCount = count($question->options);
            $stats['total_options'] += $optionCount;

            if ($optionCount < 2) {
                $stats['questions_with_insufficient_options']++;
                $stats['processing_errors'][] = "Question " . ($index + 1) . ": Must have at least 2 options";
                continue;
            }

            foreach ($question->options as $option) {
                if ($option->isCorrect) {
                    $hasCorrectAnswer = true;
                    break;
                }
            }

            if ($hasCorrectAnswer) {
                $stats['questions_with_correct_answers']++;
            } else {
                $stats['questions_without_correct_answers']++;
                $stats['processing_errors'][] = "Question " . ($index + 1) . ": No correct answer marked";
                continue;
            }

            // If we reach here, question is valid
            $validQuestions[] = $question;
            $questionData[] = [
                'author' => $userId,
                'title' => $question->text,
                'topic_id' => $request->topic_id,
                'subject_id' => $request->subject_id,
                'difficulty_level' => $question->difficulty != 'S' 
                    ? ($question->difficulty == 'M' ? 'moderate' : 'difficult') 
                    : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Check for duplicates within the uploaded batch
        $uniqueQuestions = [];
        $seenTitles = [];
        
        foreach ($validQuestions as $question) {
            $title = trim(strtolower($question->text)); // Normalize for comparison
            
            if (isset($seenTitles[$title])) {
                $stats['duplicates_in_batch']++;
                $stats['processing_errors'][] = "Duplicate question found in upload: '" . substr($question->text, 0, 50) . "...'";
            } else {
                $seenTitles[$title] = true;
                $uniqueQuestions[] = $question;
            }
        }
        
        // Get existing question titles from database for duplicate checking
        $existingTitles = [];
        if (!empty($uniqueQuestions)) {
            $existingTitles = QuestionBank::where('subject_id', $request->subject_id)
                ->pluck('title')
                ->map(function($title) {
                    return trim(strtolower($title)); // Normalize for comparison
                })
                ->flip()
                ->toArray();
        }
        
        // Check remaining unique questions against existing database questions
        $finalQuestions = [];
        foreach ($uniqueQuestions as $question) {
            $normalizedTitle = trim(strtolower($question->text));
            
            if (isset($existingTitles[$normalizedTitle])) {
                $stats['duplicates_with_existing']++;
                $stats['processing_errors'][] = "Question already exists in database: '" . substr($question->text, 0, 50) . "...'";
            } else {
                $finalQuestions[] = $question;
            }
        }

        $stats['valid_questions'] = count($validQuestions);
        $stats['unique_in_batch'] = count($uniqueQuestions);
        $stats['final_unique_questions'] = count($finalQuestions);
        $stats['invalid_questions'] = $stats['total_questions'] - $stats['valid_questions'];
        $stats['total_duplicates'] = $stats['duplicates_in_batch'] + $stats['duplicates_with_existing'];

        // Only proceed if we have final unique questions
        if (!empty($finalQuestions)) {
            // Prepare question data for final unique questions only
            $finalQuestionData = [];
            foreach ($finalQuestions as $question) {
                $finalQuestionData[] = [
                    'author' => $userId,
                    'title' => $question->text,
                    'topic_id' => $request->topic_id,
                    'subject_id' => $request->subject_id,
                    'difficulty_level' => $question->difficulty != 'S' 
                        ? ($question->difficulty == 'M' ? 'moderate' : 'difficult') 
                        : null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Bulk insert final unique questions
            QuestionBankTemp::insert($finalQuestionData);

            // Get the IDs of the inserted questions
            $insertedQuestions = QuestionBankTemp::where([
                'subject_id' => $request->subject_id, 
                'topic_id' => $request->topic_id, 
                'author' => $userId
            ])
            ->orderBy('id', 'desc')
            ->take(count($finalQuestions))
            ->get(['id'])
            ->reverse()
            ->values();

            // Prepare bulk insert data for options
            $optionData = [];
            foreach ($finalQuestions as $index => $question) {
                $questionId = $insertedQuestions[$index]->id;
                
                foreach ($question->options as $option) {
                    $optionData[] = [
                        'question_option' => $option->text,
                        'question_bank_temp_id' => $questionId,
                        'correctness' => $option->isCorrect ? '1' : '0',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            // Bulk insert options
            if (!empty($optionData)) {
                AnsweroptionsTemp::insert($optionData);
            }
        }

        // Store statistics in session for display
        session(['question_stats' => $stats]);

        return ['url' => route('admin.authoring.review', [request('subject_id'), request('topic_id')])];
    }

    /**
     * Review authored questions before final submission
     */
    public function review($subjectId, $topicId)
    {
        $questions = QuestionBankTemp::where(['subject_id' => $subjectId, 'topic_id' => $topicId, 'author' => Auth::user()->id])
            ->get();

        return view('pages.admin.questions.review', compact('questions', 'subjectId', 'topicId'));
    }

    /**
     * Submit reviewed questions to question bank
     */
    public function submit(Request $request)
    {
        try {
            $tempQuestions = QuestionBankTemp::where([
                'subject_id' => $request->subject_id, 
                'topic_id' => $request->topic_id, 
                'author' => Auth::user()->id
            ])->with('options')->get();

            if ($tempQuestions->isEmpty()) {
                return redirect(route('admin.authoring.completed', [0]));
            }

        // Since duplicates were already handled in the store function,
        // all temp questions should be unique and ready for submission
        $uniqueQuestions = $tempQuestions;

        if ($uniqueQuestions->isNotEmpty()) {
            // Prepare bulk insert data for questions
            $questionData = [];
            $now = now();

            foreach ($uniqueQuestions as $tempQuestion) {
                $questionData[] = [
                    'title' => $tempQuestion->title,
                    'active' => $tempQuestion->active,
                    'author' => $tempQuestion->author,
                    'subject_id' => $tempQuestion->subject_id,
                    'topic_id' => $tempQuestion->topic_id,
                    'difficulty_level' => $tempQuestion->difficulty_level,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Bulk insert questions
            QuestionBank::insert($questionData);

            // Get the IDs of the inserted questions
            $insertedQuestions = QuestionBank::where([
                'subject_id' => $request->subject_id,
                'topic_id' => $request->topic_id,
                'author' => Auth::user()->id
            ])
            ->orderBy('id', 'desc')
            ->take($uniqueQuestions->count())
            ->get(['id', 'title'])
            ->keyBy('title');

            // Prepare bulk insert data for options
            $optionData = [];
            foreach ($uniqueQuestions as $tempQuestion) {
                $questionId = $insertedQuestions[$tempQuestion->title]->id;
                
                foreach ($tempQuestion->options as $tempOption) {
                    $optionData[] = [
                        'question_bank_id' => $questionId,
                        'correctness' => $tempOption->correctness,
                        'question_option' => $tempOption->question_option,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            // Bulk insert options
            if (!empty($optionData)) {
                AnswerOption::insert($optionData);
            }
        }

        // Clean up temporary data
        $this->clearTemps($request->subject_id, $request->topic_id);

        // Update session stats with submission results
        $sessionStats = session('question_stats', []);
        $totalDuplicates = $sessionStats['total_duplicates'] ?? 0;
        $sessionStats['successfully_submitted'] = $uniqueQuestions->count();
        $sessionStats['submission_time'] = now()->toDateTimeString();
        session(['question_stats' => $sessionStats]);

            return redirect(route('admin.authoring.completed', [$totalDuplicates]));
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Question submission failed: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'subject_id' => $request->subject_id,
                'topic_id' => $request->topic_id,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Error submitting questions. Please try again.',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show completion status
     */
    public function completed($duplicates)
    {
        return view('pages.admin.questions.completed', compact('duplicates'));
    }

    /**
     * Show question preview interface
     */
    public function preview()
    {
        return view('pages.admin.questions.preview-questions');
    }

    /**
     * Load questions for preview
     */
    public function loadPreview(Request $request)
    {
        $where = [];
        $preview = $request->preview;

        if ($request->difficulty_level != '%')
            $where = ['difficulty_level' => $request->difficulty_level];

        $questions = QuestionBank::where([
            'subject_id' => $request->subject_id,
            'topic_id' => $request->topic_id,
            'author' => Auth::user()->id])
            ->where($where);

        $questions = $questions->get();

        return view('pages.admin.questions.ajax.ajax-preview-questions', compact('questions', 'preview'));
    }

    /**
     * Show question editing interface
     */
    public function editQuestions()
    {
        return view('pages.admin.questions.edit-questions-index');
    }

    /**
     * Edit specific question
     */
    public function editQuestion(QuestionBank $question)
    {
        return view('pages.admin.questions.edit-question', compact('question'));
    }

    /**
     * Update edited question
     */
    public function updateQuestion(Request $request)
    {
        $question = QuestionBank::where(['id' => $request->question_id])->first();
        $question->title = $request->title;
        $question->active = $request->active;
        $question->subject_id = $request->subject_id;
        $question->topic_id = $request->topic_id;
        $question->difficulty_level = $request->difficulty_level;
        $question->save();

        $index = 0;

        $options = $request->question_option;
        foreach ($question->answer_options as $option) {
            $option->question_option = $options[$index++];
            $option->correctness = $option->id == $request->input('correctness') ? 1 : 0;
            $option->save();
        }

        return redirect(route('admin.authoring.edit.questions'));
    }

    /**
     * Show move questions interface
     */
    public function moveQuestions()
    {
        return view('pages.admin.questions.move-questions');
    }

    /**
     * Load questions for moving
     */
    public function loadQuestions(Request $request)
    {
        $questions = QuestionBank::where(['subject_id' => $request->subject_id, 'topic_id' => $request->topic_id])->get();

        return view('pages.admin.questions.ajax.questions', compact('questions'));
    }

    /**
     * Move questions to different subject/topic
     */
    public function relocateQuestions(Request $request)
    {
        try {
            QuestionBank::whereIn('id', $request->question_ids)->update(['subject_id' => $request->subject_id, 'topic_id' => $request->topic_id]);

            return back()->with(['success' => true, 'message' => 'Question(s) successfully moved.']);
        } catch (\Exception $e) {
            return back()->with(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Extract content from uploaded file
     */
    private function extractContentFromFile($file)
    {
        $content = '';
        $extension = strtolower($file->getClientOriginalExtension());
        
        try {
            switch ($extension) {
                case 'txt':
                    $content = file_get_contents($file->getPathname());
                    break;
                    
                case 'doc':
                case 'docx':
                    // For Word documents, we'll need a library like PhpOffice/PhpWord
                    // For now, let's handle it as text and suggest users to save as .txt
                    $content = $this->extractTextFromWord($file);
                    break;
                    
                default:
                    throw new \Exception('Unsupported file format');
            }
            
            // Clean up the content
            $content = $this->cleanFileContent($content);
            
        } catch (\Exception $e) {
            Log::error('File content extraction failed: ' . $e->getMessage(), [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'extension' => $extension
            ]);
            
            return '';
        }
        
        return $content;
    }
    
    /**
     * Extract text from Word documents
     * Note: This is a basic implementation. For better Word support, consider using PhpOffice/PhpWord
     */
    private function extractTextFromWord($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
        if ($extension === 'docx') {
            // Try to extract from DOCX (XML-based)
            try {
                $zip = new \ZipArchive();
                if ($zip->open($file->getPathname()) !== TRUE) {
                    throw new \Exception('Cannot open DOCX file');
                }
                
                $content = $zip->getFromName('word/document.xml');
                $zip->close();
                
                if ($content !== FALSE) {
                    // Basic XML parsing to extract text
                    $content = preg_replace('/<[^>]*>/', ' ', $content);
                    $content = html_entity_decode($content);
                    return $content;
                }
            } catch (\Exception $e) {
                // Log the error and fall back to suggesting .txt format
                Log::warning('DOCX extraction failed: ' . $e->getMessage());
            }
        }
        
        // For .doc files or if DOCX extraction fails, suggest conversion
        throw new \Exception('Word document format detected. Please save your file as .txt format for better compatibility.');
    }
    
    /**
     * Clean up content extracted from files
     */
    private function cleanFileContent($content)
    {
        // Convert different line endings to uniform format
        $content = str_replace(["\r\n", "\r"], "\n", $content);
        
        // Remove excessive whitespace but preserve question structure
        $content = preg_replace('/\n{3,}/', "\n\n", $content);
        
        // Trim whitespace from beginning and end
        $content = trim($content);
        
        return $content;
    }

    /**
     * Validate a question for common issues
     */
    private function validateQuestion($question, $questionNumber)
    {
        $errors = [];

        // Check if question object is valid
        if (!is_object($question)) {
            $errors[] = "Question {$questionNumber}: Invalid question format";
            return $errors;
        }

        // Check if question has required properties
        if (!property_exists($question, 'text') || !property_exists($question, 'options') || !property_exists($question, 'difficulty')) {
            $errors[] = "Question {$questionNumber}: Missing required properties";
            return $errors;
        }

        // Check if options is an array
        if (!is_array($question->options) && !is_object($question->options)) {
            $errors[] = "Question {$questionNumber}: Options must be an array or object";
            return $errors;
        }

        // Validate each option
        $optionCount = is_array($question->options) ? count($question->options) : count((array)$question->options);
        if ($optionCount > 0) {
            foreach ($question->options as $optionIndex => $option) {
                if (!is_object($option)) {
                    $errors[] = "Question {$questionNumber}, Option " . ($optionIndex + 1) . ": Invalid option format";
                    continue;
                }

                if (!property_exists($option, 'text') || !property_exists($option, 'isCorrect')) {
                    $errors[] = "Question {$questionNumber}, Option " . ($optionIndex + 1) . ": Missing text or correctness property";
                    continue;
                }

                if (empty(trim($option->text))) {
                    $errors[] = "Question {$questionNumber}, Option " . ($optionIndex + 1) . ": Empty option text";
                }
            }
        }

        return $errors;
    }

    /**
     * Clear temporary questions
     */
    private function clearTemps($subjectId, $topicId)
    {
        $questions = QuestionBankTemp::where(['subject_id' => $subjectId, 'topic_id' => $topicId, 'author' => Auth::user()->id])->get();
        foreach ($questions as $question) {
            AnsweroptionsTemp::where(['question_bank_temp_id' => $question->id])->delete();
            $question->delete();
        }
    }
}

