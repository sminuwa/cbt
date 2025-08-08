<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupRoutePermissionScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:setup-scheduler 
                            {--remove : Remove the scheduled task}
                            {--frequency=daily : Set frequency: daily, hourly, weekly}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup automatic route-permission synchronization in Laravel scheduler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $remove = $this->option('remove');
        $frequency = $this->option('frequency');
        
        if ($remove) {
            return $this->removeScheduledTask();
        }
        
        return $this->setupScheduledTask($frequency);
    }
    
    /**
     * Setup the scheduled task
     */
    private function setupScheduledTask(string $frequency): int
    {
        $this->info('🔧 Setting up automatic route-permission synchronization...');
        
        $kernelPath = app_path('Console/Kernel.php');
        
        if (!File::exists($kernelPath)) {
            $this->error('❌ Kernel.php not found at: ' . $kernelPath);
            return self::FAILURE;
        }
        
        $kernelContent = File::get($kernelPath);
        
        // Check if the task is already scheduled
        if (str_contains($kernelContent, 'auth:sync-routes')) {
            $this->warn('⚠️  Route sync task is already scheduled');
            
            if (!$this->confirm('Do you want to update the existing scheduled task?')) {
                $this->info('❌ Setup cancelled');
                return self::SUCCESS;
            }
            
            // Remove existing task first
            $this->removeScheduledTaskFromKernel($kernelContent, $kernelPath);
            $kernelContent = File::get($kernelPath);
        }
        
        // Add the new scheduled task
        $taskCode = $this->generateScheduleCode($frequency);
        
        // Find the schedule method and add our task
        $pattern = '/(protected function schedule\(Schedule \$schedule\)[\s\S]*?{)([\s\S]*?)(^\s*})/m';
        
        if (preg_match($pattern, $kernelContent, $matches)) {
            $beforeMethod = $matches[1];
            $methodBody = $matches[2];
            $afterMethod = $matches[3];
            
            // Add our task at the end of the method body
            $newMethodBody = $methodBody . "\n        " . $taskCode . "\n";
            
            $newKernelContent = str_replace(
                $beforeMethod . $methodBody . $afterMethod,
                $beforeMethod . $newMethodBody . $afterMethod,
                $kernelContent
            );
            
            File::put($kernelPath, $newKernelContent);
            
            $this->info('✅ Successfully added route-permission sync to Laravel scheduler');
            $this->info('📅 Frequency: ' . ucfirst($frequency));
            $this->info('🔄 Task: auth:sync-routes --auto-assign');
            $this->newLine();
            
            $this->displayScheduleInfo($frequency);
            $this->displayNextSteps();
            
            return self::SUCCESS;
        } else {
            $this->error('❌ Could not find schedule() method in Kernel.php');
            $this->line('Please add the following code manually to your schedule() method:');
            $this->line('');
            $this->line($taskCode);
            
            return self::FAILURE;
        }
    }
    
    /**
     * Remove the scheduled task
     */
    private function removeScheduledTask(): int
    {
        $this->info('🗑️ Removing automatic route-permission synchronization...');
        
        $kernelPath = app_path('Console/Kernel.php');
        
        if (!File::exists($kernelPath)) {
            $this->error('❌ Kernel.php not found at: ' . $kernelPath);
            return self::FAILURE;
        }
        
        $kernelContent = File::get($kernelPath);
        
        if (!str_contains($kernelContent, 'auth:sync-routes')) {
            $this->warn('⚠️  No route sync task found in scheduler');
            return self::SUCCESS;
        }
        
        $updated = $this->removeScheduledTaskFromKernel($kernelContent, $kernelPath);
        
        if ($updated) {
            $this->info('✅ Successfully removed route-permission sync from Laravel scheduler');
        } else {
            $this->error('❌ Failed to remove scheduled task');
            return self::FAILURE;
        }
        
        return self::SUCCESS;
    }
    
    /**
     * Remove scheduled task from kernel content
     */
    private function removeScheduledTaskFromKernel(string $kernelContent, string $kernelPath): bool
    {
        // Remove lines containing auth:sync-routes
        $lines = explode("\n", $kernelContent);
        $filteredLines = array_filter($lines, function($line) {
            return !str_contains($line, 'auth:sync-routes');
        });
        
        $newContent = implode("\n", $filteredLines);
        
        if ($newContent !== $kernelContent) {
            File::put($kernelPath, $newContent);
            return true;
        }
        
        return false;
    }
    
    /**
     * Generate the schedule code based on frequency
     */
    private function generateScheduleCode(string $frequency): string
    {
        $baseCommand = '$schedule->command(\'auth:sync-routes --auto-assign\')';
        
        switch ($frequency) {
            case 'hourly':
                return $baseCommand . '->hourly()->withoutOverlapping();';
            case 'weekly':
                return $baseCommand . '->weekly()->withoutOverlapping();';
            case 'daily':
            default:
                return $baseCommand . '->daily()->withoutOverlapping();';
        }
    }
    
    /**
     * Display schedule information
     */
    private function displayScheduleInfo(string $frequency): void
    {
        $this->info('📋 Schedule Details:');
        
        switch ($frequency) {
            case 'hourly':
                $this->line('   🕐 Runs: Every hour at minute 0');
                $this->line('   📅 Next run: Top of the next hour');
                break;
            case 'weekly':
                $this->line('   📅 Runs: Every Sunday at 00:00');
                $this->line('   📅 Next run: Next Sunday');
                break;
            case 'daily':
            default:
                $this->line('   🌙 Runs: Every day at 00:00 (midnight)');
                $this->line('   📅 Next run: Tonight at midnight');
                break;
        }
        
        $this->line('   🔒 Protection: withoutOverlapping() prevents concurrent runs');
        $this->line('   🤖 Action: Automatically adds new route permissions to Super Admin role');
    }
    
    /**
     * Display next steps
     */
    private function displayNextSteps(): void
    {
        $this->newLine();
        $this->info('📝 Next Steps:');
        $this->line('1. Make sure Laravel scheduler is running in cron:');
        $this->line('   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1');
        $this->newLine();
        $this->line('2. Test the scheduler:');
        $this->line('   php artisan schedule:list');
        $this->newLine();
        $this->line('3. Run sync manually anytime:');
        $this->line('   php artisan auth:sync-routes --auto-assign');
        $this->newLine();
        $this->line('4. Check sync logs:');
        $this->line('   tail -f storage/logs/route-permission-sync.log');
        $this->newLine();
        $this->warn('⚠️  Important: Make sure to commit your Kernel.php changes to version control');
    }
}