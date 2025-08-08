<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizationRoutesTest extends TestCase
{
    /**
     * Test that authorization routes are properly defined
     */
    public function test_authorization_routes_exist()
    {
        // Test that authorization users index route exists
        $response = $this->get(route('admin.authorization.users.index'));
        
        // Should either return 200 (if authenticated) or redirect to login
        $this->assertContains($response->getStatusCode(), [200, 302]);
    }
    
    /**
     * Test that authorization user save route exists
     */
    public function test_authorization_user_save_route_exists()
    {
        // Test POST route exists (will likely fail auth but route should exist)
        $response = $this->post(route('admin.authorization.user.save'), []);
        
        // Should either return validation errors or redirect (not 404)
        $this->assertNotEquals(404, $response->getStatusCode());
    }
    
    /**
     * Test that authorization role index route exists
     */
    public function test_authorization_role_index_route_exists()
    {
        // Test that authorization role index route exists
        $response = $this->get(route('admin.authorization.role.index'));
        
        // Should either return 200 (if authenticated) or redirect to login
        $this->assertContains($response->getStatusCode(), [200, 302]);
    }
}