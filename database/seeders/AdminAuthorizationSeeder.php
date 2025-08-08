<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Define all admin routes and their descriptions
        $adminRoutes = [
            // Authentication
            'admin.auth.login' => 'Access admin login page',
            'admin.auth.login.proc' => 'Process admin login',
            'admin.auth.logout' => 'Admin logout',
            
            // Dashboard
            'admin.dashboard.index' => 'View admin dashboard',
            'admin.configuration' => 'Access system configuration',
            
            // Question Authoring
            'admin.authoring.index' => 'Access question authoring interface',
            'admin.authoring.store' => 'Submit questions for review',
            'admin.authoring.review' => 'Review authored questions',
            'admin.authoring.submit' => 'Submit questions to question bank',
            'admin.authoring.completed' => 'View authoring completion status',
            'admin.authoring.preview' => 'Access question preview interface',
            'admin.authoring.load.preview' => 'Load question preview',
            'admin.authoring.topics' => 'Get topics by subject',
            'admin.authoring.topics.add' => 'Add new topic',
            'admin.authoring.edit.questions' => 'Access question editing interface',
            'admin.authoring.edit.question' => 'Edit specific question',
            'admin.authoring.update.question' => 'Update question',
            'admin.authoring.move.questions' => 'Access question moving interface',
            'admin.authoring.load.questions' => 'Load questions for moving',
            'admin.authoring.relocate.questions' => 'Relocate questions to different subject/topic',
            
            // Authorization Management
            'admin.authorization.users.index' => 'View users management',
            'admin.authorization.user.save' => 'Create new user',
            'admin.authorization.user.edit' => 'Edit existing user',
            'admin.authorization.role.index' => 'View roles management',
            'admin.authorization.role.save' => 'Create new role',
            'admin.authorization.permission.save' => 'Create new permission',
            'admin.authorization.role.permission' => 'View role permissions',
            'admin.authorization.role.users' => 'View role users',
            'admin.authorization.role.permission.save' => 'Assign permissions to role',
            'admin.authorization.role.user.save' => 'Assign user to role',
            'admin.authorization.role.user.detach' => 'Remove user from role',
            
            // Questions Management
            'admin.questions.index' => 'View questions management',
            
            // Reports
            'admin.reports.index' => 'View reports dashboard',
            'admin.reports.test.index' => 'View test reports',
            'admin.reports.test.generate' => 'Generate test reports',
            'admin.reports.summary.reports' => 'View summary reports',
            'admin.reports.summary.generate.report' => 'Generate summary reports',
            'admin.reports.summary.question' => 'View question summary',
            'admin.reports.summary.generate.question' => 'Generate question summary',
            'admin.reports.summary.presentation' => 'View presentation summary',
            'admin.reports.summary.generate.presentation' => 'Generate presentation summary',
            'admin.reports.active.index' => 'View active candidates',
            'admin.reports.active.generate' => 'Generate active candidates report',
            
            // Exam Setup
            'admin.exams.setup.index' => 'Access exam setup',
            'admin.exams.setup.push' => 'Push exam configurations',
            'admin.exams.setup.pull.basic' => 'Pull basic resources',
            'admin.exams.setup.pull.test' => 'Pull test resources',
            'admin.exams.setup.pull.candidate' => 'Pull candidate resources',
            'admin.exams.setup.pull.candidate.pictures' => 'Pull candidate pictures',
            
            // Test Configuration
            'admin.test.config.index' => 'View test configurations',
            'admin.test.config.store' => 'Create test configuration',
            'admin.test.config.delete' => 'Delete test configuration',
            'admin.test.config.view' => 'View test configuration details',
            'admin.test.config.basics' => 'Access test basic settings',
            'admin.test.config.basics.store' => 'Save test basic settings',
            'admin.test.config.dates' => 'Manage test dates',
            'admin.test.config.dates.store' => 'Store test dates',
            'admin.test.config.dates.delete' => 'Delete test dates',
            'admin.test.config.schedules' => 'Manage test schedules',
            'admin.test.config.schedules.store' => 'Store test schedules',
            'admin.test.config.schedules.reschedule' => 'Reschedule tests',
            'admin.test.config.schedules.delete' => 'Delete test schedules',
            'admin.test.config.schedules.remove.delete' => 'Remove and delete schedules',
            'admin.test.config.schedules.others' => 'View other schedules',
            'admin.test.config.subjects' => 'Manage test subjects',
            'admin.test.config.subjects.ajax' => 'Get test subjects via AJAX',
            'admin.test.config.registered.subjects' => 'View registered subjects',
            'admin.test.config.subject.register' => 'Register subject to test',
            'admin.test.config.subject.remove' => 'Remove subject from test',
            'admin.test.config.mappings' => 'Manage test mappings',
            'admin.test.config.mappings.store' => 'Store test mappings',
            'admin.test.config.composition' => 'Manage test composition',
            'admin.test.config.composition.compose' => 'Compose test sections',
            'admin.test.config.composition.compose.store' => 'Store test composition',
            'admin.test.config.composition.section.delete' => 'Delete test section',
            'admin.test.config.composition.compose.questions' => 'Manage test questions',
            'admin.test.config.compose.questions.load' => 'Load questions for composition',
            'admin.test.config.compose.questions.store' => 'Store questions in composition',
            'admin.test.config.compose.questions.remove' => 'Remove questions from composition',
            'admin.test.config.compose.preview.questions' => 'Preview composed questions',
            'admin.test.config.composition.preview' => 'Preview test composition',
            'admin.test.config.manage.users' => 'Manage test users',
            'admin.test.config.manage.users.add.compositor' => 'Add compositor to test',
            'admin.test.config.manage.users.add.invigilator' => 'Add invigilator to test',
            'admin.test.config.manage.users.add.previewer' => 'Add previewer to test',
            'admin.test.config.manage.users.search.compositor' => 'Search compositors',
            'admin.test.config.manage.users.remove.compositor' => 'Remove compositor from test',
            'admin.test.config.manage.users.remove.invigilator' => 'Remove invigilator from test',
            'admin.test.config.manage.users.remove.previewer' => 'Remove previewer from test',
            'admin.test.config.upload.options' => 'Access candidate upload options',
            'admin.test.config.upload.list' => 'Upload candidate list',
            'admin.test.config.upload.all.candidates' => 'Upload all candidates',
            
            // Toolbox - Candidate Types
            'admin.toolbox.candidate-types.index' => 'Manage candidate types',
            'admin.toolbox.candidate-types.store' => 'Create candidate type',
            'admin.toolbox.candidate-types.delete' => 'Delete candidate type',
            
            // Toolbox - Center & Venue
            'admin.toolbox.center_venue.home' => 'Manage centers and venues',
            'admin.toolbox.center_venue.center.store' => 'Create center',
            'admin.toolbox.center_venue.center.edit' => 'Edit center',
            'admin.toolbox.center_venue.center.destroy' => 'Delete center',
            'admin.toolbox.center_venue.venue.store' => 'Create venue',
            'admin.toolbox.center_venue.venue.delete' => 'Delete venue',
            
            // Toolbox - Subjects
            'admin.toolbox.subject.home' => 'Manage subjects',
            'admin.toolbox.subject.store' => 'Create subject',
            'admin.toolbox.subject.delete' => 'Delete subject',
            
            // Toolbox - Topics
            'admin.toolbox.topics.index' => 'Manage topics',
            'admin.toolbox.topics.store' => 'Create topic',
            'admin.toolbox.topics.delete' => 'Delete topic',
            
            // Toolbox - Test Codes
            'admin.toolbox.test-codes.index' => 'Manage test codes',
            'admin.toolbox.test-codes.store' => 'Create test code',
            'admin.toolbox.test-codes.delete' => 'Delete test code',
            
            // Toolbox - Test Types
            'admin.toolbox.test-types.index' => 'Manage test types',
            'admin.toolbox.test-types.store' => 'Create test type',
            'admin.toolbox.test-types.delete' => 'Delete test type',
            
            // Toolbox - Candidate Upload
            'admin.toolbox.candidate_upload.upload.candidate' => 'Upload candidates',
            'admin.toolbox.candidate_upload.upload.candidate.data' => 'Process candidate upload',
            
            // Toolbox - Candidate Image Upload
            'admin.toolbox.candidate_image_upload.upload.images' => 'Upload candidate images',
            'admin.toolbox.candidate_image_upload.upload.image.data' => 'Process image upload',
            
            // Toolbox - Invigilator Panel
            'admin.toolbox.invigilator.index' => 'Access invigilator panel',
            'admin.toolbox.invigilator.increase-time.view' => 'View time increase options',
            'admin.toolbox.invigilator.save-time.adjust' => 'Adjust candidate time',
            'admin.toolbox.invigilator.reset.password' => 'Reset candidate password',
            'admin.toolbox.invigilator.candidate.loadProfile' => 'Load candidate profile',
            
            // Miscellaneous
            'admin.misc.venues' => 'Get venues by center',
            'admin.misc.faculty.mappings' => 'Get faculty mappings',
            'admin.misc.batches.capacity' => 'Get batch capacity',
            'admin.misc.test.config' => 'Get test configuration',
            'admin.misc.test.subjects' => 'Get test subjects',
            'admin.misc.test.candidates' => 'Get test candidates',
        ];

        // Get existing permissions to avoid duplicates
        $existingPermissions = DB::table('permissions')->pluck('name')->toArray();
        
        // Prepare permissions data
        $permissionsData = [];
        foreach ($adminRoutes as $routeName => $description) {
            if (!in_array($routeName, $existingPermissions)) {
                $permissionsData[] = [
                    'name' => $routeName,
                    'description' => $description,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Insert permissions in batches to avoid memory issues
        if (!empty($permissionsData)) {
            $chunks = array_chunk($permissionsData, 50);
            foreach ($chunks as $chunk) {
                DB::table('permissions')->insert($chunk);
            }
            $this->command->info('Inserted ' . count($permissionsData) . ' new permissions.');
        } else {
            $this->command->info('All permissions already exist.');
        }

        // Create or update Super Admin role
        $superAdminRole = DB::table('roles')->where('name', 'Super Admin')->first();
        if (!$superAdminRole) {
            $superAdminRoleId = DB::table('roles')->insertGetId([
                'name' => 'Super Admin',
                'description' => 'Super Administrator with full system access',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $this->command->info('Created Super Admin role.');
        } else {
            $superAdminRoleId = $superAdminRole->id;
            $this->command->info('Super Admin role already exists.');
        }

        // Get all permissions
        $allPermissions = DB::table('permissions')->get(['id', 'name']);
        
        // Get existing role permissions to avoid duplicates
        $existingRolePermissions = DB::table('role_permissions')
            ->where('role_id', $superAdminRoleId)
            ->pluck('permission_id')
            ->toArray();

        // Assign all permissions to Super Admin role
        $rolePermissionsData = [];
        foreach ($allPermissions as $permission) {
            if (!in_array($permission->id, $existingRolePermissions)) {
                $rolePermissionsData[] = [
                    'role_id' => $superAdminRoleId,
                    'permission_id' => $permission->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($rolePermissionsData)) {
            $chunks = array_chunk($rolePermissionsData, 50);
            foreach ($chunks as $chunk) {
                DB::table('role_permissions')->insert($chunk);
            }
            $this->command->info('Assigned ' . count($rolePermissionsData) . ' permissions to Super Admin role.');
        } else {
            $this->command->info('Super Admin role already has all permissions.');
        }

        // Assign Super Admin role to admin user (ID: 1)
        $adminUserId = 1;
        $existingUserRole = DB::table('user_roles')
            ->where('user_id', $adminUserId)
            ->where('role_id', $superAdminRoleId)
            ->first();

        if (!$existingUserRole) {
            DB::table('user_roles')->insert([
                'user_id' => $adminUserId,
                'role_id' => $superAdminRoleId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $this->command->info('Assigned Super Admin role to admin user.');
        } else {
            $this->command->info('Admin user already has Super Admin role.');
        }

        $this->command->info('Authorization system setup completed successfully!');
        $this->command->info('Total permissions in system: ' . $allPermissions->count());
        $this->command->info('Super Admin role has access to all permissions.');
        $this->command->info('Admin user (ID: 1) has Super Admin role.');
    }
}