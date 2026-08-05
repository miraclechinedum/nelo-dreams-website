<?php

namespace Tests\Feature;

use App\Models\MediaItem;
use App\Models\Post;
use App\Models\User;
use App\Support\MediaStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    /** Every uploaded file created during a test, so we can clean up after. */
    private array $written = [];

    protected function tearDown(): void
    {
        foreach ($this->written as $path) {
            MediaStorage::delete($path);
        }

        parent::tearDown();
    }

    private function admin(): User
    {
        return User::factory()->create();
    }

    private function trackUploads(): void
    {
        $this->written = array_merge(
            $this->written,
            MediaItem::pluck('path')->all(),
            MediaItem::whereNotNull('poster')->pluck('poster')->all(),
            Post::whereNotNull('cover_image')->pluck('cover_image')->all(),
        );
    }

    public function test_admin_pages_require_signing_in(): void
    {
        foreach (['/admin', '/admin/posts', '/admin/media', '/admin/messages', '/admin/account'] as $url) {
            $this->get($url)->assertRedirect('/admin/login');
        }
    }

    public function test_an_admin_can_sign_in_and_out(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret-password')]);

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'secret-password'])
            ->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);

        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_wrong_credentials_are_rejected(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret-password')]);

        $this->from('/admin/login')
            ->post('/admin/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_an_admin_can_publish_a_post_with_a_photo_and_a_video(): void
    {
        $response = $this->actingAs($this->admin())->post('/admin/posts', [
            'title' => 'Mental Health Outreach in Lugbe',
            'summary' => 'A mental health engagement for commercial drivers in the Lugbe metropolis.',
            'body' => "First paragraph.\n\n- A bullet\n- Another bullet",
            'category' => 'Community Outreach',
            'location' => 'Lugbe, FCT Abuja',
            'happened_on' => '2025-06-12',
            'hashtags' => '#MentalHealthAwareness',
            'is_active' => '1',
            'media' => [
                UploadedFile::fake()->image('drivers.jpg'),
                UploadedFile::fake()->create('outreach.mp4', 64, 'video/mp4'),
            ],
        ]);

        $post = Post::firstWhere('slug', 'mental-health-outreach-in-lugbe');
        $this->trackUploads();

        $response->assertRedirect(route('admin.posts.edit', $post));
        $this->assertNotNull($post);
        $this->assertTrue($post->is_active);
        $this->assertSame(2, $post->media()->count());
        $this->assertSame(1, $post->media()->where('type', 'video')->count());

        // The photo landed in public/uploads and is reachable from the browser.
        $photo = $post->media()->where('type', 'image')->first();
        $this->assertStringStartsWith('uploads/', $photo->path);
        $this->assertFileExists(public_path($photo->path));

        // …and the post is live on the public site.
        $this->get(route('updates.show', $post))
            ->assertOk()
            ->assertSee('Mental Health Outreach in Lugbe')
            ->assertSee('A bullet');
    }

    public function test_a_draft_post_is_hidden_from_the_public_site(): void
    {
        $post = Post::create([
            'title' => 'Not ready yet',
            'slug' => 'not-ready-yet',
            'summary' => 'Still being written.',
            'is_active' => false,
        ]);

        $this->get(route('updates.show', $post))->assertNotFound();
        $this->get(route('updates.index'))->assertOk()->assertDontSee('Not ready yet');

        $this->actingAs($this->admin())->patch(route('admin.posts.toggle', $post));

        $this->assertTrue($post->fresh()->is_active);
        $this->get(route('updates.show', $post))->assertOk();
    }

    public function test_an_admin_can_upload_a_photo_to_the_home_page_gallery(): void
    {
        $this->actingAs($this->admin())->post('/admin/media', [
            'type' => 'image',
            'file' => UploadedFile::fake()->image('school-visit.jpg'),
            'title' => 'School visit',
            'caption' => 'Pupils at the assembly.',
            'span' => 'wide',
            'in_gallery' => '1',
            'is_active' => '1',
        ])->assertRedirect('/admin/media');

        $item = MediaItem::firstWhere('title', 'School visit');
        $this->trackUploads();

        $this->assertNotNull($item);
        $this->assertTrue($item->in_gallery);
        $this->assertFileExists(public_path($item->path));

        $this->get('/')->assertOk()->assertSee('Pupils at the assembly.', false);
    }

    public function test_deleting_media_removes_the_uploaded_file(): void
    {
        $this->actingAs($this->admin())->post('/admin/media', [
            'type' => 'image',
            'file' => UploadedFile::fake()->image('temporary.jpg'),
            'span' => 'normal',
            'is_active' => '1',
        ]);

        $item = MediaItem::latest('id')->first();
        $path = public_path($item->path);
        $this->assertFileExists($path);

        $this->actingAs($this->admin())->delete(route('admin.media.destroy', $item));

        $this->assertFileDoesNotExist($path);
        $this->assertDatabaseMissing('media_items', ['id' => $item->id]);
    }

    public function test_seeded_photos_are_never_deleted_from_disk(): void
    {
        // Paths outside `uploads/` ship with the repo — removing the record
        // must not remove the file.
        $item = MediaItem::create([
            'type' => 'image',
            'path' => 'images/gallery/assembly.jpg',
            'span' => 'normal',
        ]);

        $this->actingAs($this->admin())->delete(route('admin.media.destroy', $item));

        $this->assertFileExists(public_path('images/gallery/assembly.jpg'));
    }

    public function test_an_admin_can_change_their_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('old-password-123')]);

        $this->actingAs($user)->patch('/admin/account', [
            'name' => $user->name,
            'email' => $user->email,
            'current_password' => 'old-password-123',
            'password' => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
        ])->assertSessionHasNoErrors();

        $this->assertTrue(password_verify('brand-new-password', $user->fresh()->password));
    }
}
