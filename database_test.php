<?php

/**
 * Database Performance Test Script
 * Place this in your Laravel root directory and run: php database_test.php
 * This will help identify which queries are slow and causing timeouts
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

echo "=== Dashboard Database Performance Test ===\n\n";

// Test database connection
try {
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n\n";
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test queries individually to identify slow ones
$queries = [
    'Basic Centres Count' => "SELECT COUNT(*) as count FROM centres",
    'Basic Candidates Count' => "SELECT COUNT(*) as count FROM candidates", 
    'Basic Scores Count' => "SELECT COUNT(*) as count FROM scores",
    'Test Codes with Configs' => "
        SELECT tc.name, COUNT(tcfg.id) as configs 
        FROM test_codes tc 
        LEFT JOIN test_configs tcfg ON tcfg.test_code_id = tc.id 
        GROUP BY tc.id, tc.name 
        LIMIT 10
    ",
    'Centres with Venues' => "
        SELECT c.name, COUNT(v.id) as venues 
        FROM centres c 
        LEFT JOIN venues v ON v.centre_id = c.id 
        GROUP BY c.id, c.name 
        LIMIT 10
    ",
    'Scheduled Candidates Sample' => "
        SELECT COUNT(*) as count 
        FROM scheduled_candidates sc 
        INNER JOIN schedulings s ON s.id = sc.schedule_id 
        LIMIT 1000
    ",
    'Time Controls Sample' => "
        SELECT COUNT(*) as completed, COUNT(*) - COUNT(CASE WHEN completed = 1 THEN 1 END) as in_progress
        FROM time_controls 
        LIMIT 1000
    "
];

foreach ($queries as $name => $query) {
    echo "Testing: $name\n";
    $start = microtime(true);
    
    try {
        $result = DB::select($query);
        $duration = round((microtime(true) - $start) * 1000, 2);
        
        if ($duration > 2000) {
            echo "  ⚠️  SLOW: {$duration}ms\n";
        } elseif ($duration > 500) {
            echo "  ⚡ MEDIUM: {$duration}ms\n";
        } else {
            echo "  ✓ FAST: {$duration}ms\n";
        }
        
        echo "  Result count: " . count($result) . "\n";
        
    } catch (Exception $e) {
        echo "  ✗ FAILED: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

// Test the heavy queries that are causing timeouts
echo "=== Testing Heavy Dashboard Queries ===\n\n";

$heavyQueries = [
    'Centre Performance (Simplified)' => "
        SELECT 
            c.name as centre_name,
            COUNT(DISTINCT sc.candidate_id) as total_candidates
        FROM centres c
        INNER JOIN venues v ON v.centre_id = c.id
        INNER JOIN schedulings sch ON sch.venue_id = v.id
        INNER JOIN scheduled_candidates sc ON sc.schedule_id = sch.id
        GROUP BY c.id, c.name
        HAVING total_candidates > 0
        ORDER BY total_candidates DESC
        LIMIT 5
    ",
    'Subject Performance (Basic)' => "
        SELECT 
            sub.name as subject_name,
            COUNT(DISTINCT cs.scheduled_candidate_id) as enrolled_candidates
        FROM subjects sub
        INNER JOIN candidate_subjects cs ON cs.subject_id = sub.id
        GROUP BY sub.id, sub.name
        HAVING enrolled_candidates > 0
        ORDER BY enrolled_candidates DESC
        LIMIT 5
    "
];

foreach ($heavyQueries as $name => $query) {
    echo "Testing Heavy Query: $name\n";
    $start = microtime(true);
    
    try {
        $result = DB::select($query);
        $duration = round((microtime(true) - $start) * 1000, 2);
        
        if ($duration > 5000) {
            echo "  🔥 VERY SLOW: {$duration}ms - This will timeout in AJAX!\n";
        } elseif ($duration > 2000) {
            echo "  ⚠️  SLOW: {$duration}ms - May cause timeouts\n";
        } else {
            echo "  ✓ ACCEPTABLE: {$duration}ms\n";
        }
        
        echo "  Result count: " . count($result) . "\n";
        
    } catch (Exception $e) {
        echo "  ✗ FAILED: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "=== Recommendations ===\n";
echo "• Queries over 2000ms will likely timeout in AJAX requests\n";
echo "• Queries over 5000ms definitely need optimization\n";
echo "• Consider adding database indexes for frequently joined columns\n";
echo "• Use LIMIT clauses to reduce result sets\n";
echo "• Consider caching slow query results\n";
echo "\nTest completed.\n";
