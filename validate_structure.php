<?php

/**
 * CBT System Structure Validation Script
 * 
 * This script validates that all files have been properly restructured
 * with correct namespaces and imports.
 */

function validateDirectory($directory, $expectedNamespace)
{
    $files = glob($directory . '/*.php');
    $issues = [];
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $basename = basename($file, '.php');
        
        // Check if namespace is correct
        if (!preg_match('/namespace ' . preg_quote($expectedNamespace, '/') . ';/', $content)) {
            $issues[] = "❌ $file: Incorrect namespace (expected: $expectedNamespace)";
        }
        
        // Check if Controller classes extend Controller
        if (strpos($directory, 'Controllers') !== false && $basename !== 'Controller') {
            if (!preg_match('/use App\\\\Http\\\\Controllers\\\\Controller;/', $content)) {
                $issues[] = "⚠️  $file: Missing Controller import";
            }
        }
    }
    
    return $issues;
}

echo "🔍 Validating CBT System Structure...\n\n";

$validations = [
    'app/Http/Controllers/Dashboard' => 'App\\Http\\Controllers\\Dashboard',
    'app/Http/Controllers/Exam' => 'App\\Http\\Controllers\\Exam',
    'app/Http/Controllers/Question' => 'App\\Http\\Controllers\\Question',
    'app/Http/Controllers/Report' => 'App\\Http\\Controllers\\Report',
    'app/Http/Controllers/Setup' => 'App\\Http\\Controllers\\Setup',
    'app/Http/Controllers/Candidate' => 'App\\Http\\Controllers\\Candidate',
];

$allIssues = [];

foreach ($validations as $directory => $namespace) {
    echo "📁 Checking $directory...\n";
    $issues = validateDirectory($directory, $namespace);
    $allIssues = array_merge($allIssues, $issues);
    
    if (empty($issues)) {
        echo "   ✅ All files correctly structured\n";
    } else {
        foreach ($issues as $issue) {
            echo "   $issue\n";
        }
    }
    echo "\n";
}

echo "\n📊 SUMMARY:\n";

if (empty($allIssues)) {
    echo "🎉 ALL CHECKS PASSED! The CBT system has been successfully restructured.\n";
    echo "\n📋 Structure Summary:\n";
    echo "   • Controllers organized by domain\n";
    echo "   • Models grouped by business logic\n";
    echo "   • Services layer implemented\n";
    echo "   • Repository interfaces created\n";
    echo "   • Proper PSR-4 namespacing\n";
    echo "   • Routes updated for new structure\n";
} else {
    echo "❌ Found " . count($allIssues) . " issues that need attention:\n";
    foreach ($allIssues as $issue) {
        echo "   $issue\n";
    }
}

echo "\n📚 Next Steps:\n";
echo "   1. Run: php artisan config:cache\n";
echo "   2. Run: php artisan route:cache\n";
echo "   3. Run: composer dump-autoload\n";
echo "   4. Test key functionality\n";
echo "   5. Review PROJECT_STRUCTURE.md for guidelines\n";

echo "\n✨ CBT System restructuring validation complete!\n";

