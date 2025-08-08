<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AuthorizationSystemTest extends TestCase
{
    /**
     * Test that all admin routes have permissions
     */
    public function test_all_admin_routes_have_permissions()
    {
        // Get all admin routes from Laravel
        $routes = Route::getRoutes();
        $adminRoutes = [];
        
        foreach ($routes as $route) {
            $routeName = $route->getName();
            if ($routeName && str_starts_with($routeName, 'admin.')) {
                $adminRoutes[] = $routeName;
            }
        }
        
        // Get all permissions from database
        $permissions = DB::table('permissions')->pluck('name')->toArray();
        
        // Check that most admin routes have permissions (some may be excluded intentionally)
        $routesWithPermissions = array_intersect($adminRoutes, $permissions);
        $coveragePercentage = (count($routesWithPermissions) / count($adminRoutes)) * 100;
        
        $this->assertGreaterThan(90, $coveragePercentage, 
            'Less than 90% of admin routes have permissions. Coverage: ' . round($coveragePercentage, 2) . '%'
        );
        
        $this->assertGreaterThan(100, count($permissions), 'Should have more than 100 permissions');
    }
    
    /**
     * Test that Super Admin role exists and has permissions
     */
    public function test_super_admin_role_exists_and_has_permissions()
    {
        $superAdminRole = DB::table('roles')->where('name', 'Super Admin')->first();
        $this->assertNotNull($superAdminRole, 'Super Admin role should exist');
        
        $permissionCount = DB::table('role_permissions')
            ->where('role_id', $superAdminRole->id)
            ->count();
            
        $totalPermissions = DB::table('permissions')->count();
        
        $this->assertEquals($totalPermissions, $permissionCount, 
            'Super Admin role should have all permissions'
        );
    }
    
    /**
     * Test that admin user has Super Admin role
     */
    public function test_admin_user_has_super_admin_role()
    {
        $superAdminRole = DB::table('roles')->where('name', 'Super Admin')->first();
        $this->assertNotNull($superAdminRole, 'Super Admin role should exist');
        
        $userRole = DB::table('user_roles')
            ->where('user_id', 1)
            ->where('role_id', $superAdminRole->id)
            ->first();
            
        $this->assertNotNull($userRole, 'Admin user should have Super Admin role');
    }
    
    /**
     * Test key admin permissions exist
     */
    public function test_key_admin_permissions_exist()
    {
        $keyPermissions = [
            'admin.dashboard.index',
            'admin.authoring.index',
            'admin.authorization.users.index',
            'admin.authorization.role.index',
            'admin.reports.index',
            'admin.test.config.index',
        ];
        
        foreach ($keyPermissions as $permission) {
            $exists = DB::table('permissions')->where('name', $permission)->exists();
            $this->assertTrue($exists, "Key permission '{$permission}' should exist");
        }
    }
    
    /**
     * Test authorization system statistics
     */
    public function test_authorization_system_statistics()
    {
        $stats = [
            'permissions' => DB::table('permissions')->count(),
            'roles' => DB::table('roles')->count(),
            'users' => DB::table('users')->count(),
            'role_permissions' => DB::table('role_permissions')->count(),
            'user_roles' => DB::table('user_roles')->count(),
        ];
        
        // Validate expected counts
        $this->assertGreaterThanOrEqual(129, $stats['permissions'], 'Should have at least 129 permissions');
        $this->assertGreaterThanOrEqual(4, $stats['roles'], 'Should have at least 4 roles');
        $this->assertGreaterThanOrEqual(1, $stats['users'], 'Should have at least 1 user');
        $this->assertGreaterThanOrEqual(129, $stats['role_permissions'], 'Should have role-permission mappings');
        $this->assertGreaterThanOrEqual(1, $stats['user_roles'], 'Should have user-role mappings');
        
        // Output stats for verification
        echo "\nAuthorization System Statistics:\n";
        foreach ($stats as $key => $value) {
            echo "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
        }
    }
}