<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SyncRoutesWithPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:sync-routes 
                            {--dry-run : Show what would be done without making changes}
                            {--remove-orphaned : Remove permissions for routes that no longer exist}
                            {--auto-assign : Automatically assign new permissions to Super Admin role}
                            {--force : Force sync even if no changes detected}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize route changes with the permissions system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting Route-Permission Synchronization...');
        $this->newLine();

        $isDryRun = $this->option('dry-run');
        $removeOrphaned = $this->option('remove-orphaned');
        $autoAssign = $this->option('auto-assign');
        $force = $this->option('force');

        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
            $this->newLine();
        }

        // Get current routes
        $currentRoutes = $this->getCurrentAdminRoutes();
        $this->info('📋 Found ' . count($currentRoutes) . ' admin routes in application');

        // Get existing permissions
        $existingPermissions = DB::table('permissions')
            ->where('name', 'like', 'admin.%')
            ->pluck('name', 'id')
            ->toArray();
        
        $this->info('📋 Found ' . count($existingPermissions) . ' admin permissions in database');
        $this->newLine();

        // Find new routes (routes that don't have permissions yet)
        $newRoutes = array_diff($currentRoutes, $existingPermissions);
        
        // Find orphaned permissions (permissions for routes that no longer exist)
        $orphanedPermissions = array_diff($existingPermissions, $currentRoutes);

        // Display analysis
        $this->displayAnalysis($newRoutes, $orphanedPermissions, $force);

        if (empty($newRoutes) && empty($orphanedPermissions) && !$force) {
            $this->info('✅ No synchronization needed. All routes and permissions are in sync.');
            return self::SUCCESS;
        }

        if (!$force && empty($newRoutes) && empty($orphanedPermissions)) {
            $this->info('✅ No changes detected. Use --force to run anyway.');
            return self::SUCCESS;
        }

        // Confirm before making changes (unless dry run or force)
        if (!$isDryRun && !$force) {
            if (!$this->confirm('Do you want to proceed with these changes?')) {
                $this->info('❌ Synchronization cancelled.');
                return self::SUCCESS;
            }
        }

        // Process changes
        $stats = [
            'added' => 0,
            'removed' => 0,
            'assigned' => 0,
            'errors' => 0,
        ];

        // Add new permissions
        if (!empty($newRoutes)) {
            $stats['added'] = $this->addNewPermissions($newRoutes, $isDryRun, $autoAssign);
            if ($autoAssign && !$isDryRun) {
                $stats['assigned'] = $this->assignToSuperAdmin($newRoutes);
            }
        }

        // Remove orphaned permissions
        if (!empty($orphanedPermissions) && $removeOrphaned) {
            $stats['removed'] = $this->removeOrphanedPermissions($orphanedPermissions, $isDryRun);
        }

        // Display results
        $this->displayResults($stats, $isDryRun);

        // Create backup of changes
        if (!$isDryRun && ($stats['added'] > 0 || $stats['removed'] > 0)) {
            $this->createSyncLog($newRoutes, $orphanedPermissions, $stats);
        }

        return self::SUCCESS;
    }

    /**
     * Get all current admin routes from the application
     */
    private function getCurrentAdminRoutes(): array
    {
        $routes = Route::getRoutes();
        $adminRoutes = [];

        foreach ($routes as $route) {
            $routeName = $route->getName();
            if ($routeName && str_starts_with($routeName, 'admin.')) {
                $adminRoutes[] = $routeName;
            }
        }

        return array_unique($adminRoutes);
    }

    /**
     * Display analysis of what will be changed
     */
    private function displayAnalysis(array $newRoutes, array $orphanedPermissions, bool $force): void
    {
        if (!empty($newRoutes)) {
            $this->warn('🆕 New Routes Found (' . count($newRoutes) . '):');
            foreach ($newRoutes as $route) {
                $this->line('   + ' . $route);
            }
            $this->newLine();
        }

        if (!empty($orphanedPermissions)) {
            $this->error('🗑️ Orphaned Permissions Found (' . count($orphanedPermissions) . '):');
            foreach ($orphanedPermissions as $permission) {
                $this->line('   - ' . $permission);
            }
            if ($this->option('remove-orphaned')) {
                $this->warn('   ⚠️  These will be REMOVED (--remove-orphaned flag detected)');
            } else {
                $this->info('   ℹ️  Use --remove-orphaned flag to remove these');
            }
            $this->newLine();
        }

        if ($this->option('auto-assign') && !empty($newRoutes)) {
            $this->info('🔄 New permissions will be automatically assigned to Super Admin role');
            $this->newLine();
        }
    }

    /**
     * Add new permissions to the database
     */
    private function addNewPermissions(array $newRoutes, bool $isDryRun, bool $autoAssign): int
    {
        if ($isDryRun) {
            $this->info('🔍 [DRY RUN] Would add ' . count($newRoutes) . ' new permissions');
            return count($newRoutes);
        }

        $now = Carbon::now();
        $permissionsData = [];

        foreach ($newRoutes as $route) {
            $description = $this->generatePermissionDescription($route);
            $permissionsData[] = [
                'name' => $route,
                'description' => $description,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        try {
            // Insert in batches to avoid memory issues
            $chunks = array_chunk($permissionsData, 50);
            foreach ($chunks as $chunk) {
                DB::table('permissions')->insert($chunk);
            }

            $this->info('✅ Added ' . count($newRoutes) . ' new permissions');
            
            // Show added permissions
            foreach ($newRoutes as $route) {
                $this->line('   + ' . $route);
            }

            return count($newRoutes);
        } catch (\Exception $e) {
            $this->error('❌ Error adding permissions: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Remove orphaned permissions from the database
     */
    private function removeOrphanedPermissions(array $orphanedPermissions, bool $isDryRun): int
    {
        if ($isDryRun) {
            $this->info('🔍 [DRY RUN] Would remove ' . count($orphanedPermissions) . ' orphaned permissions');
            return count($orphanedPermissions);
        }

        try {
            // First remove from role_permissions table
            $permissionIds = DB::table('permissions')
                ->whereIn('name', $orphanedPermissions)
                ->pluck('id')
                ->toArray();

            if (!empty($permissionIds)) {
                $rolePermissionCount = DB::table('role_permissions')
                    ->whereIn('permission_id', $permissionIds)
                    ->count();

                DB::table('role_permissions')
                    ->whereIn('permission_id', $permissionIds)
                    ->delete();

                // Then remove from permissions table
                $removedCount = DB::table('permissions')
                    ->whereIn('name', $orphanedPermissions)
                    ->delete();

                $this->warn('🗑️ Removed ' . $removedCount . ' orphaned permissions');
                $this->warn('🗑️ Removed ' . $rolePermissionCount . ' role-permission mappings');

                foreach ($orphanedPermissions as $permission) {
                    $this->line('   - ' . $permission);
                }

                return $removedCount;
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error removing orphaned permissions: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Assign new permissions to Super Admin role
     */
    private function assignToSuperAdmin(array $newRoutes): int
    {
        $superAdminRole = DB::table('roles')->where('name', 'Super Admin')->first();
        
        if (!$superAdminRole) {
            $this->warn('⚠️ Super Admin role not found. Skipping auto-assignment.');
            return 0;
        }

        // Get IDs of new permissions
        $newPermissionIds = DB::table('permissions')
            ->whereIn('name', $newRoutes)
            ->pluck('id', 'name')
            ->toArray();

        if (empty($newPermissionIds)) {
            return 0;
        }

        $now = Carbon::now();
        $rolePermissionsData = [];

        foreach ($newPermissionIds as $routeName => $permissionId) {
            $rolePermissionsData[] = [
                'role_id' => $superAdminRole->id,
                'permission_id' => $permissionId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        try {
            DB::table('role_permissions')->insert($rolePermissionsData);
            $this->info('🔄 Assigned ' . count($rolePermissionsData) . ' new permissions to Super Admin role');
            return count($rolePermissionsData);
        } catch (\Exception $e) {
            $this->error('❌ Error assigning permissions to Super Admin: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Generate a human-readable description for a permission
     */
    private function generatePermissionDescription(string $route): string
    {
        // Parse route parts
        $parts = explode('.', $route);
        
        if (count($parts) < 3) {
            return ucfirst(str_replace(['.', '_', '-'], ' ', $route));
        }

        $module = $parts[1] ?? '';
        $action = end($parts);
        $subModule = count($parts) > 3 ? $parts[2] : '';

        // Generate description based on common patterns
        $descriptions = [
            'index' => 'View ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'store' => 'Create ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'save' => 'Save ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'edit' => 'Edit ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'update' => 'Update ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'delete' => 'Delete ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'destroy' => 'Remove ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'show' => 'View ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')) . ' details',
            'generate' => 'Generate ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'upload' => 'Upload ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
            'download' => 'Download ' . $this->humanize($module . ($subModule ? ' ' . $subModule : '')),
        ];

        return $descriptions[$action] ?? ucfirst(str_replace(['.', '_', '-'], ' ', $route));
    }

    /**
     * Convert string to human-readable format
     */
    private function humanize(string $text): string
    {
        return ucfirst(str_replace(['.', '_', '-'], ' ', $text));
    }

    /**
     * Display final results
     */
    private function displayResults(array $stats, bool $isDryRun): void
    {
        $this->newLine();
        $this->info('📊 Synchronization Results:');
        
        $mode = $isDryRun ? ' (DRY RUN)' : '';
        
        if ($stats['added'] > 0) {
            $this->info('   ✅ Permissions Added: ' . $stats['added'] . $mode);
        }
        
        if ($stats['removed'] > 0) {
            $this->warn('   🗑️ Permissions Removed: ' . $stats['removed'] . $mode);
        }
        
        if ($stats['assigned'] > 0) {
            $this->info('   🔄 Assigned to Super Admin: ' . $stats['assigned'] . $mode);
        }
        
        if ($stats['errors'] > 0) {
            $this->error('   ❌ Errors: ' . $stats['errors']);
        }

        if ($stats['added'] === 0 && $stats['removed'] === 0 && $stats['errors'] === 0) {
            $this->info('   ℹ️ No changes made');
        }

        if (!$isDryRun && ($stats['added'] > 0 || $stats['removed'] > 0)) {
            $this->newLine();
            $this->info('💡 Tip: Run "php artisan auth:check" to verify the updated system');
        }
    }

    /**
     * Create a log of the synchronization changes
     */
    private function createSyncLog(array $newRoutes, array $orphanedPermissions, array $stats): void
    {
        $logData = [
            'timestamp' => Carbon::now()->toDateTimeString(),
            'added_routes' => $newRoutes,
            'removed_permissions' => $orphanedPermissions,
            'statistics' => $stats,
        ];

        $logFile = storage_path('logs/route-permission-sync.log');
        $logEntry = date('Y-m-d H:i:s') . ' - Route Permission Sync: ' . json_encode($logData) . PHP_EOL;
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        $this->line('📝 Sync log saved to: ' . $logFile);
    }
}