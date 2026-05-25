<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_submission_is_stored(): void
    {
        $payload = [
            'name' => 'Ada Obi',
            'email' => 'ada@example.com',
            'phone' => '08012345678',
            'interest' => 'Partner',
            'message' => 'We would love to bring a program to our school next term.',
        ];

        $this->post('/contact', $payload)
            ->assertRedirect()
            ->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'ada@example.com',
            'interest' => 'Partner',
        ]);
    }

    public function test_invalid_submission_is_rejected(): void
    {
        $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'short',
        ])->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_honeypot_blocks_spam(): void
    {
        $this->post('/contact', [
            'name' => 'Spam Bot',
            'email' => 'spam@example.com',
            'message' => 'This is an automated spam message for testing.',
            'website' => 'http://spam.example',
        ])->assertSessionHasErrors('website');

        $this->assertSame(0, ContactMessage::count());
    }
}
