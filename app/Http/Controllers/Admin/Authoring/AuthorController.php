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
                'difficulty_level' => $question->difficulty == 'S' ? 'simple' 
                    : ($question->difficulty == 'M' ? 'moderate' : 'difficult'),
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
                    'difficulty_level' => $question->difficulty == 'S' ? 'simple' 
                        : ($question->difficulty == 'M' ? 'moderate' : 'difficult'),
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
     * Load questions with advanced filtering for improved interface
     */
    public function loadQuestionsImproved(Request $request)
    {
        try {
            $query = QuestionBank::with(['answer_options'])
                ->where('author', Auth::user()->id);

            // Apply filters
            if ($request->filled('subject_id')) {
                $query->where('subject_id', $request->subject_id);
            }

            if ($request->filled('topic_id')) {
                $query->where('topic_id', $request->topic_id);
            }

            if ($request->filled('difficulty_level')) {
                $query->where('difficulty_level', $request->difficulty_level);
            }

            if ($request->filled('status')) {
                $query->where('active', $request->status);
            }

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('id', 'LIKE', '%' . $search . '%')
                      ->orWhereHas('answer_options', function($optQuery) use ($search) {
                          $optQuery->where('question_option', 'LIKE', '%' . $search . '%');
                      });
                });
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortDirection = $request->get('sort_direction', 'desc');
            $query->orderBy($sortBy, $sortDirection);

            // Pagination
            $perPage = $request->get('per_page', 25);
            $questions = $query->paginate($perPage);

            // Calculate statistics
            $stats = $this->calculateQuestionStats($request);

            // Generate HTML for questions
            $html = $this->renderQuestionsHTML($questions, $request->boolean('bulk_mode'));

            // Generate pagination HTML
            $pagination = $questions->appends($request->all())->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'stats' => $stats,
                'total' => $questions->total()
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading questions: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading questions. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get single question for editing
     */
    public function getQuestion(QuestionBank $question)
    {
        // Ensure user can only edit their own questions
        if ($question->author !== Auth::user()->id) {
            abort(403, 'Unauthorized access to this question.');
        }

        $question->load('answer_options');
        
        return view('pages.admin.questions.partials.edit-question-form', compact('question'));
    }

    /**
     * Delete a question
     */
    public function deleteQuestion(Request $request)
    {
        try {
            $question = QuestionBank::where('id', $request->question_id)
                ->where('author', Auth::user()->id)
                ->first();

            if (!$question) {
                return response()->json([
                    'success' => false,
                    'message' => 'Question not found or you do not have permission to delete it.'
                ], 404);
            }

            // Delete associated answer options first
            $question->answer_options()->delete();
            
            // Delete the question
            $question->delete();

            return response()->json([
                'success' => true,
                'message' => 'Question deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting question: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'question_id' => $request->question_id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting question. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk edit questions
     */
    public function bulkEditQuestions(Request $request)
    {
        try {
            $questionIds = explode(',', $request->selected_questions);
            $questionIds = array_filter($questionIds); // Remove empty values

            if (empty($questionIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No questions selected.'
                ], 400);
            }

            $updated = 0;
            $updateData = [];

            // Prepare update data
            if ($request->filled('bulk_subject_id')) {
                $updateData['subject_id'] = $request->bulk_subject_id;
            }

            if ($request->filled('bulk_topic_id')) {
                $updateData['bulk_topic_id'] = $request->bulk_topic_id;
            }

            if ($request->filled('bulk_difficulty')) {
                $updateData['difficulty_level'] = $request->bulk_difficulty;
            }

            if ($request->filled('bulk_status')) {
                $updateData['active'] = $request->bulk_status;
            }

            if (!empty($updateData)) {
                $updateData['updated_at'] = now();
                
                $updated = QuestionBank::whereIn('id', $questionIds)
                    ->where('author', Auth::user()->id)
                    ->update($updateData);
            }

            return response()->json([
                'success' => true,
                'message' => 'Questions updated successfully.',
                'updated' => $updated
            ]);

        } catch (\Exception $e) {
            Log::error('Error bulk editing questions: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating questions. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk delete questions
     */
    public function bulkDeleteQuestions(Request $request)
    {
        try {
            $questionIds = $request->question_ids;

            if (empty($questionIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No questions selected.'
                ], 400);
            }

            // Delete answer options first
            AnswerOption::whereHas('question_bank', function($query) use ($questionIds) {
                $query->whereIn('id', $questionIds)
                      ->where('author', Auth::user()->id);
            })->delete();

            // Delete questions
            $deleted = QuestionBank::whereIn('id', $questionIds)
                ->where('author', Auth::user()->id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Questions deleted successfully.',
                'deleted' => $deleted
            ]);

        } catch (\Exception $e) {
            Log::error('Error bulk deleting questions: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting questions. Please try again.'
            ], 500);
        }
    }

    /**
     * Export questions
     */
    public function exportQuestions(Request $request)
    {
        try {
            $query = QuestionBank::with(['answer_options', 'subject', 'topic'])
                ->where('author', Auth::user()->id);

            // Apply same filters as the main query
            if ($request->filled('subject_id')) {
                $query->where('subject_id', $request->subject_id);
            }

            if ($request->filled('topic_id')) {
                $query->where('topic_id', $request->topic_id);
            }

            if ($request->filled('difficulty_level')) {
                $query->where('difficulty_level', $request->difficulty_level);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('id', 'LIKE', '%' . $search . '%');
                });
            }

            // If exporting selected questions only
            if ($request->boolean('selected_only') && $request->filled('selected_questions')) {
                $selectedIds = explode(',', $request->selected_questions);
                $query->whereIn('id', $selectedIds);
            }

            $questions = $query->get();

            // Generate CSV
            $filename = 'questions_export_' . date('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($questions) {
                $file = fopen('php://output', 'w');
                
                // CSV headers
                fputcsv($file, [
                    'ID', 'Subject', 'Topic', 'Question', 'Difficulty', 'Status',
                    'Option A', 'Option B', 'Option C', 'Option D', 'Correct Answer',
                    'Created Date', 'Updated Date'
                ]);

                foreach ($questions as $question) {
                    $options = $question->answer_options->pluck('question_option')->toArray();
                    $correctAnswer = '';
                    
                    foreach ($question->answer_options as $index => $option) {
                        if ($option->correctness == 1) {
                            $correctAnswer = chr(65 + $index); // A, B, C, D...
                            break;
                        }
                    }

                    fputcsv($file, [
                        $question->id,
                        $question->subject ? $question->subject->name : 'N/A',
                        $question->topic ? $question->topic->name : 'N/A',
                        strip_tags($question->title),
                        ucfirst($question->difficulty_level ?? ''),
                        $question->active ? 'Active' : 'Inactive',
                        isset($options[0]) ? strip_tags($options[0]) : '',
                        isset($options[1]) ? strip_tags($options[1]) : '',
                        isset($options[2]) ? strip_tags($options[2]) : '',
                        isset($options[3]) ? strip_tags($options[3]) : '',
                        $correctAnswer,
                        $question->created_at->format('Y-m-d H:i:s'),
                        $question->updated_at->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error exporting questions: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Error exporting questions. Please try again.');
        }
    }

    /**
     * Calculate question statistics
     */
    private function calculateQuestionStats(Request $request)
    {
        $baseQuery = QuestionBank::where('author', Auth::user()->id);

        // Apply same filters as main query for accurate stats
        if ($request->filled('subject_id')) {
            $baseQuery->where('subject_id', $request->subject_id);
        }

        if ($request->filled('topic_id')) {
            $baseQuery->where('topic_id', $request->topic_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('id', 'LIKE', '%' . $search . '%');
            });
        }

        return [
            'total' => $baseQuery->count(),
            'simple' => (clone $baseQuery)->where('difficulty_level', 'simple')->count(),
            'moderate' => (clone $baseQuery)->where('difficulty_level', 'moderate')->count(),
            'difficult' => (clone $baseQuery)->where('difficulty_level', 'difficult')->count(),
        ];
    }

    /**
     * Export questions in DOCX format (compatible with authoring format)
     */
    public function exportQuestionsDocx(Request $request)
    {
        try {
            $query = QuestionBank::with(['answer_options', 'subject', 'topic'])
                ->where('author', Auth::user()->id);

            // Apply same filters as the main query
            if ($request->filled('subject_id')) {
                $query->where('subject_id', $request->subject_id);
            }

            if ($request->filled('topic_id')) {
                $query->where('topic_id', $request->topic_id);
            }

            if ($request->filled('difficulty_level')) {
                $query->where('difficulty_level', $request->difficulty_level);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('id', 'LIKE', '%' . $search . '%');
                });
            }

            // If exporting selected questions only
            if ($request->boolean('selected_only') && $request->filled('selected_questions')) {
                $selectedIds = explode(',', $request->selected_questions);
                $query->whereIn('id', $selectedIds);
            }

            $questions = $query->get();

            // Generate DOCX
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();

            // Add header
            $section->addTitle('Question Bank Export', 1);
            $section->addText('Subject: ' . ($questions->first()->subject->name ?? 'Mixed Subjects'));
            $section->addText('Topic: ' . ($questions->first()->topic->name ?? 'Mixed Topics'));
            $section->addText('Total Questions: ' . $questions->count());
            $section->addText('Export Date: ' . now()->format('Y-m-d H:i:s'));
            $section->addTextBreak(2);

            // Add format guide
            $section->addTitle('Format Guide', 2);
            $section->addText('This document uses the following format markers:');
            $section->addText('?? - Question separator');
            $section->addText('** - Option separator');
            $section->addText('== - Correct answer marker');
            $section->addText('{S} - Simple difficulty, {M} - Moderate difficulty, {D} - Difficult difficulty');
            $section->addTextBreak(2);

            // Add questions in authoring format
            foreach ($questions as $question) {
                // Convert difficulty level to format code
                $difficultyCode = 'M'; // Default to moderate
                switch ($question->difficulty_level) {
                    case 'simple':
                        $difficultyCode = 'S';
                        break;
                    case 'moderate':
                        $difficultyCode = 'M';
                        break;
                    case 'difficult':
                        $difficultyCode = 'D';
                        break;
                }

                // Add question text with difficulty marker
                $questionText = '??' . strip_tags($question->title) . ' {' . $difficultyCode . '}';
                $section->addText($questionText);

                // Add options
                if ($question->answer_options && count($question->answer_options) > 0) {
                    foreach ($question->answer_options as $option) {
                        $optionText = $option->correctness == 1 
                            ? '**' . strip_tags($option->question_option) . ' =='
                            : '**' . strip_tags($option->question_option);
                        $section->addText($optionText);
                    }
                }

                $section->addTextBreak(1);
            }

            // Create temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'questions_export');
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($tempFile);

            // Generate filename
            $filename = 'questions_export_' . date('Y-m-d_H-i-s') . '.docx';

            // Return file download
            return response()->download($tempFile, $filename)->deleteFileAfterSend();

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting questions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Render questions HTML using partial view
     */
    private function renderQuestionsHTML($questions, $bulkMode = false)
    {
        return view('pages.admin.questions.partials.questions-list', [
            'questions' => $questions,
            'bulkMode' => $bulkMode,
            'showPagination' => false
        ])->render();
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

