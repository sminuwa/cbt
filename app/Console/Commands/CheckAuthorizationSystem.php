<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckAuthorizationSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:check {--detailed : Show detailed information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the authorization system setup and display statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== CBT Authorization System Status ===');
        $this->newLine();

        // Get basic statistics
        $stats = [
            'permissions' => DB::table('permissions')->count(),
            'roles' => DB::table('roles')->count(),
            'users' => DB::table('users')->count(),
            'role_permissions' => DB::table('role_permissions')->count(),
            'user_roles' => DB::table('user_roles')->count(),
        ];

        // Display basic statistics
        $this->info('📊 System Statistics:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Permissions', $stats['permissions']],
                ['Total Roles', $stats['roles']],
                ['Total Users', $stats['users']],
                ['Role-Permission Mappings', $stats['role_permissions']],
                ['User-Role Mappings', $stats['user_roles']],
            ]
        );

        // Check Super Admin role
        $superAdminRole = DB::table('roles')->where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $superAdminPermissions = DB::table('role_permissions')
                ->where('role_id', $superAdminRole->id)
                ->count();
            
            $this->info('✅ Super Admin Role: Found (ID: ' . $superAdminRole->id . ')');
            $this->info('   └─ Has ' . $superAdminPermissions . ' permissions');
            
            if ($superAdminPermissions === $stats['permissions']) {
                $this->info('   └─ ✅ Has ALL permissions');
            } else {
                $this->warn('   └─ ⚠️  Missing ' . ($stats['permissions'] - $superAdminPermissions) . ' permissions');
            }
        } else {
            $this->error('❌ Super Admin Role: Not found');
        }

        // Check admin user
        $adminUser = DB::table('users')->where('id', 1)->first();
        if ($adminUser) {
            $userRoles = DB::select('
                SELECT r.name, r.id 
                FROM roles r 
                JOIN user_roles ur ON r.id = ur.role_id 
                WHERE ur.user_id = ?
            ', [1]);

            $this->info('✅ Admin User: Found (' . $adminUser->username . ')');
            foreach ($userRoles as $role) {
                $this->info('   └─ Has role: ' . $role->name . ' (ID: ' . $role->id . ')');
            }

            $hasSuperAdmin = collect($userRoles)->contains('name', 'Super Admin');
            if ($hasSuperAdmin) {
                $this->info('   └─ ✅ Has Super Admin role');
            } else {
                $this->warn('   └─ ⚠️  Does not have Super Admin role');
            }
        } else {
            $this->error('❌ Admin User: Not found');
        }

        // Check key permissions
        $keyPermissions = [
            'admin.dashboard.index',
            'admin.authoring.index',
            'admin.authorization.users.index',
            'admin.reports.index',
        ];

        $this->newLine();
        $this->info('🔑 Key Permissions Check:');
        foreach ($keyPermissions as $permission) {
            $exists = DB::table('permissions')->where('name', $permission)->exists();
            if ($exists) {
                $this->info('   ✅ ' . $permission);
            } else {
                $this->error('   ❌ ' . $permission . ' - Missing');
            }
        }

        // Detailed information if requested
        if ($this->option('detailed')) {
            $this->newLine();
            $this->info('📋 Detailed Information:');
            
            // Show all roles
            $roles = DB::table('roles')->get();
            $this->info('Roles:');
            foreach ($roles as $role) {
                $permissionCount = DB::table('role_permissions')->where('role_id', $role->id)->count();
                $userCount = DB::table('user_roles')->where('role_id', $role->id)->count();
                $this->info("   • {$role->name} (ID: {$role->id}) - {$permissionCount} permissions, {$userCount} users");
            }

            // Show admin-related permissions
            $adminPermissions = DB::table('permissions')
                ->where('name', 'like', 'admin.%')
                ->orderBy('name')
                ->get(['name', 'description']);
            
            $this->newLine();
            $this->info('Admin Permissions (' . $adminPermissions->count() . ' total):');
            
            // Group by category for better display
            $categories = [];
            foreach ($adminPermissions as $permission) {
                $parts = explode('.', $permission->name);
                if (count($parts) >= 3) {
                    $category = $parts[1]; // admin.{category}.{action}
                    if (!isset($categories[$category])) {
                        $categories[$category] = [];
                    }
                    $categories[$category][] = $permission->name;
                }
            }

            foreach ($categories as $category => $perms) {
                $this->info("   📁 {$category}: " . count($perms) . " permissions");
                if (count($perms) <= 10) { // Show details only for small categories
                    foreach ($perms as $perm) {
                        $this->line("      └─ {$perm}");
                    }
                }
            }
        }

        $this->newLine();
        $this->info('🎉 Authorization system check completed!');
        
        if ($superAdminRole && $adminUser && $hasSuperAdmin) {
            $this->info('✅ System is properly configured');
            return self::SUCCESS;
        } else {
            $this->error('❌ System configuration issues detected');
            return self::FAILURE;
        }
    }
}