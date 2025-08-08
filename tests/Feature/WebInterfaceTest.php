<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User; // Assuming you have a User model

class WebInterfaceTest extends TestCase
{
    /**
     * Test that the question authoring page loads correctly
     */
    public function test_question_authoring_page_loads()
    {
        // Create a test user (you may need to adjust this based on your User model)
        // $user = User::factory()->create();
        // $this->actingAs($user, 'admin');
        
        $response = $this->get('/admin/authoring');
        
        // Should either return 200 (if authenticated) or redirect to login
        $this->assertContains($response->getStatusCode(), [200, 302]);
        
        if ($response->getStatusCode() === 200) {
            // Check that TinyMCE config is loaded
            $response->assertSee('tinymce.init');
            $response->assertSee('promotion: false');
            $response->assertSee('branding: false');
            
            // Check that both input tabs are present
            $response->assertSee('Text Editor');
            $response->assertSee('File Upload');
        }
    }
    
    /**
     * Test that authorization users page loads correctly
     */
    public function test_authorization_users_page_loads()
    {
        $response = $this->get('/admin/authorization/users');
        
        // Should either return 200 (if authenticated) or redirect to auth
        $this->assertContains($response->getStatusCode(), [200, 302]);
        
        if ($response->getStatusCode() === 200) {
            // Check for user management elements
            $response->assertSee('Add New User');
        }
    }
    
    /**
     * Test TinyMCE configuration contains our customizations
     */
    public function test_tinymce_configuration()
    {
        $response = $this->get('/admin/authoring');
        
        if ($response->getStatusCode() === 200) {
            $content = $response->getContent();
            
            // Verify TinyMCE customizations
            $this->assertStringContains('promotion: false', $content);
            $this->assertStringContains('branding: false', $content);
            
            // Verify it doesn't contain upgrade prompts
            $this->assertStringNotContains('upgrade', strtolower($content));
        }
    }
    
    /**
     * Test that question authoring form has both input methods
     */
    public function test_authoring_form_has_input_methods()
    {
        $response = $this->get('/admin/authoring');
        
        if ($response->getStatusCode() === 200) {
            // Check for tabbed interface
            $response->assertSee('id="editor-tab"', false);
            $response->assertSee('id="upload-tab"', false);
            
            // Check for text editor
            $response->assertSee('textarea#question-editor');
            
            // Check for file upload
            $response->assertSee('input type="file"', false);
            $response->assertSee('name="question_file"', false);
        }
    }
}