<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_renders_successfully(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Every Child Deserves')
            ->assertSee('Glad You Were Born');
    }

    public function test_homepage_shows_seeded_content(): void
    {
        $this->get('/')
            ->assertSee('Children Reached')
            ->assertSee('Mind Matters School Program')
            ->assertSee('Football Builds More Than Players')
            ->assertSee('Diamond Tech Innovations')
            ->assertSee('rangersintlfcfoundation@gmail.com');
    }

    public function test_homepage_renders_all_core_sections(): void
    {
        $response = $this->get('/');

        foreach (['id="about"', 'id="objectives"', 'id="programs"', 'id="values"', 'id="impact"', 'id="partnership"', 'id="approach"', 'id="contact"'] as $marker) {
            $response->assertSee($marker, false);
        }
    }
}
