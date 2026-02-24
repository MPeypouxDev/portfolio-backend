<?php

namespace Tests\Feature\Contact;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_send_contact_message_with_valid_data()
    {
        $response = $this->postJson('/api/contact', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0612345678',
            'messages' => 'Ceci est un message de test',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Message sent successfully',
                 ]);

        $this->assertDatabaseHas('contacts', [
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function contact_form_validates_required_fields()
    {
        $response = $this->postJson('/api/contact', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'first_name',
                     'last_name',
                     'email',
                     'messages',
                 ]);
    }

    /** @test */
    public function contact_form_validates_email_format()
    {
        $response = $this->postJson('/api/contact', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'invalid-email',
            'messages' => 'Test message',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }
}