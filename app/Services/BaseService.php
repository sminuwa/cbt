<?php

namespace App\Services;

abstract class BaseService
{
    /**
     * Handle database transactions safely
     */
    protected function executeInTransaction(callable $callback)
    {
        return \DB::transaction($callback);
    }

    /**
     * Handle exceptions consistently
     */
    protected function handleException(\Exception $e, string $message = 'An error occurred')
    {
        \Log::error($message . ': ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);

        throw new \Exception($message . ': ' . $e->getMessage());
    }

    /**
     * Validate required data
     */
    protected function validateRequired(array $data, array $required)
    {
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new \InvalidArgumentException("Required field '{$field}' is missing or empty");
            }
        }
    }
}

