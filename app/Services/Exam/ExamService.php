<?php

namespace App\Services\Exam;

use App\Services\BaseService;
use App\Models\Exam\TestConfig;
use App\Models\Exam\ExamsDate;
use App\Models\Exam\Scheduling;
use App\Models\Exam\ScheduledCandidate;
use App\Models\Candidate\CandidateSubject;
use Illuminate\Support\Facades\DB;

class ExamService extends BaseService
{
    /**
     * Create a new test configuration
     */
    public function createTestConfig(array $data): TestConfig
    {
        $this->validateRequired($data, ['title', 'session', 'test_type_id', 'test_code_id']);

        return $this->executeInTransaction(function () use ($data) {
            $config = new TestConfig();
            $config->fill($data);
            $config->date_initiated = now();
            $config->total_mark = 0.0;
            $config->save();

            return $config;
        });
    }

    /**
     * Update test configuration basics
     */
    public function updateTestBasics(int $configId, array $data): TestConfig
    {
        return $this->executeInTransaction(function () use ($configId, $data) {
            $config = TestConfig::findOrFail($configId);
            
            $config->duration = $data['duration'] ?? $config->duration;
            $config->pass_key = $data['pass_key'] ?? $config->pass_key;
            $config->status = $data['availability'] ?? $config->status;
            $config->allow_calc = $data['allow_calc'] ?? $config->allow_calc;
            $config->endorsement = $data['endorsement'] ?? $config->endorsement;
            $config->time_padding = $data['time_padding'] ?? $config->time_padding;
            $config->display_mode = $data['display_mode'] ?? $config->display_mode;
            $config->starting_mode = $data['starting_mode'] ?? $config->starting_mode;
            $config->option_administration = $data['option_administration'] ?? $config->option_administration;
            $config->question_administration = $data['question_administration'] ?? $config->question_administration;
            
            $config->save();
            
            return $config;
        });
    }

    /**
     * Add exam date to test configuration
     */
    public function addExamDate(int $configId, string $date): ExamsDate
    {
        return $this->executeInTransaction(function () use ($configId, $date) {
            $examDate = new ExamsDate();
            $examDate->test_config_id = $configId;
            $examDate->date = $date;
            $examDate->save();

            return $examDate;
        });
    }

    /**
     * Create a new scheduling for a test configuration
     */
    public function createScheduling(array $data): Scheduling
    {
        $this->validateRequired($data, ['test_config_id', 'venue_id', 'date']);

        return $this->executeInTransaction(function () use ($data) {
            $scheduling = new Scheduling();
            $scheduling->fill($data);
            $scheduling->save();

            return $scheduling;
        });
    }

    /**
     * Schedule candidates for an exam
     */
    public function scheduleCandidates(int $scheduleId, array $candidateIds, int $examTypeId): array
    {
        return $this->executeInTransaction(function () use ($scheduleId, $candidateIds, $examTypeId) {
            $scheduledCandidates = [];
            
            foreach ($candidateIds as $candidateId) {
                $scheduledCandidate = ScheduledCandidate::updateOrCreate(
                    [
                        'schedule_id' => $scheduleId,
                        'candidate_id' => $candidateId,
                        'exam_type_id' => $examTypeId
                    ]
                );
                $scheduledCandidates[] = $scheduledCandidate;
            }

            return $scheduledCandidates;
        });
    }

    /**
     * Get test configurations with related data
     */
    public function getTestConfigurations(array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = TestConfig::with([
            'test_type', 
            'test_code', 
            'test_subjects',
            'exams_dates',
            'schedulings',
            'test_compositors',
            'test_invigilators'
        ])
        ->withCount([
            'exams_dates',
            'schedulings', 
            'test_subjects',
            'test_compositors',
            'test_invigilators'
        ]);

        if (isset($filters['session'])) {
            $query->where('session', $filters['session']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('session', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    /**
     * Delete a test configuration and related data
     */
    public function deleteTestConfiguration(int $configId): bool
    {
        return $this->executeInTransaction(function () use ($configId) {
            $config = TestConfig::findOrFail($configId);
            
            // Delete related data
            $config->exams_dates()->delete();
            $config->test_subjects()->delete();
            $config->test_compositors()->delete();
            $config->test_invigilators()->delete();
            
            // Delete schedulings and related data
            foreach ($config->schedulings as $scheduling) {
                $scheduling->scheduled_candidates()->delete();
                $scheduling->delete();
            }
            
            $config->delete();
            
            return true;
        });
    }
}

