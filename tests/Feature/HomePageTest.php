<?php

namespace Tests\Feature;

use App\Models\TeamMember;
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
            ->assertSee(config('site.email'));
    }

    public function test_homepage_shows_the_team(): void
    {
        $this->get('/')
            ->assertSee('The People Behind the Work')
            ->assertSee('Coach Ebere Amariazu')
            ->assertSee('Executive Director')
            ->assertSee('Esther Osayi');
    }

    public function test_a_hidden_team_member_is_not_shown(): void
    {
        $member = TeamMember::firstWhere('name', 'Esther Osayi');
        $member->update(['is_active' => false]);

        $this->get('/')
            ->assertDontSee('Esther Osayi')
            ->assertSee('Coach Ebere Amariazu');
    }

    public function test_homepage_renders_all_core_sections(): void
    {
        $response = $this->get('/');

        foreach (['id="about"', 'id="objectives"', 'id="programs"', 'id="values"', 'id="impact"', 'id="partnership"', 'id="approach"', 'id="team"', 'id="contact"'] as $marker) {
            $response->assertSee($marker, false);
        }
    }
}
