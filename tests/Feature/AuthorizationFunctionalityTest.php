<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationFunctionalityTest extends TestCase
{
    /**
     * Test authorization users index route accessibility
     */
    public function test_authorization_users_index_route()
    {
        $response = $this->get('/admin/authorization/users');
        
        // Should either redirect to login or return 200 if authenticated
        $this->assertContains($response->getStatusCode(), [200, 302]);
        
        // If redirected, it should be to authentication
        if ($response->getStatusCode() === 302) {
            $this->assertThat(
                $response->getTargetUrl(),
                $this->logicalOr(
                    $this->stringContains('login'),
                    $this->stringContains('auth')
                )
            );
        }
    }
    
    /**
     * Test authorization user save route exists and handles POST request
     */
    public function test_authorization_user_save_route()
    {
        $response = $this->post('/admin/authorization/user/save', [
            '_token' => csrf_token(),
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
        
        // Should not return 404 (route exists)
        $this->assertNotEquals(404, $response->getStatusCode());
        
        // Should either redirect (successful) or return validation/auth errors
        $this->assertContains($response->getStatusCode(), [200, 302, 401, 403, 422]);
    }
    
    /**
     * Test authorization role index route
     */
    public function test_authorization_role_index_route()
    {
        $response = $this->get('/admin/authorization/role');
        
        // Should either redirect to login or return 200 if authenticated
        $this->assertContains($response->getStatusCode(), [200, 302]);
    }
    
    /**
     * Test that route names are correctly defined
     */
    public function test_route_names_exist()
    {
        // Test that the route helper can resolve these routes
        $this->assertTrue(route_exists('admin.authorization.users.index'));
        $this->assertTrue(route_exists('admin.authorization.user.save'));
        $this->assertTrue(route_exists('admin.authorization.role.index'));
    }
}

/**
 * Helper function to check if route exists
 */
function route_exists($name)
{
    try {
        return (bool) route($name);
    } catch (\Exception $e) {
        return false;
    }
}