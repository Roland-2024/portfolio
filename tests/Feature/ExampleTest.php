<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\PortfolioProfile;
use App\Models\User;
use Database\Seeders\PortfolioContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PortfolioContentSeeder::class);
    }

    public function test_portfolio_page_is_rendered_from_laravel(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Roland Aga OS | Portfolio')
            ->assertSee('Roland Aga')
            ->assertSee('Full Stack Software Developer')
            ->assertSee('info@rolandaga.com')
            ->assertSee('1UP LABS')
            ->assertSee('Municipality of Tirana')
            ->assertSee('https://www.linkedin.com/in/roland-aga-a74906146/', false)
            ->assertSee(asset('assets/profile/roland-cartoon.png'), false)
            ->assertSee('All Programs')
            ->assertSee('all-programs-menu')
            ->assertSee('roland://about')
            ->assertSee('roland://projects')
            ->assertSee('Music Player window')
            ->assertSee('Media Player window')
            ->assertSee('Paint window')
            ->assertSee('Command Prompt window')
            ->assertSee('Image Viewer window')
            ->assertSee('data-menu="file"', false)
            ->assertSee('data-project-search', false)
            ->assertSee('fullscreen-toggle')
            ->assertSee(asset('styles.css'), false)
            ->assertSee(asset('script.js'), false);
    }

    public function test_dashboard_requires_authentication_and_admin_can_log_in(): void
    {
        $admin = User::factory()->create(['email' => 'admin@example.com', 'password' => 'secret-password']);

        $this->get('/admin')->assertRedirect('/admin/login');

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'secret-password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/admin')->assertOk()->assertSee('Manage the content shown on your portfolio.');
    }

    public function test_admin_can_update_public_profile_content(): void
    {
        $admin = User::factory()->create();
        $profile = PortfolioProfile::firstOrFail();

        $this->actingAs($admin)->put('/admin/profile', [
            'name' => 'Roland Updated',
            'title' => $profile->title,
            'location' => $profile->location,
            'email' => $profile->email,
            'phone' => $profile->phone,
            'website' => $profile->website,
            'upwork_url' => $profile->upwork_url,
            'intro' => $profile->intro,
            'bio' => $profile->bio,
            'secondary_bio' => $profile->secondary_bio,
            'years_experience' => $profile->years_experience,
            'full_stack_years' => $profile->full_stack_years,
            'availability' => $profile->availability,
            'languages' => $profile->languages,
        ])->assertSessionHasNoErrors();

        $this->get('/')->assertOk()->assertSee('Roland Updated');
    }

    public function test_contact_form_stores_message_and_sends_email(): void
    {
        Mail::fake();

        $this->postJson('/contact', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'message' => 'I would like to discuss a Laravel project.',
        ])->assertCreated()->assertJson(['message' => 'Thank you. Your message has been sent.']);

        $this->assertDatabaseHas('contact_messages', ['email' => 'jane@example.com', 'is_read' => false]);
        Mail::assertSent(ContactMessageReceived::class);
    }

    public function test_contact_notification_can_be_rendered_and_sent(): void
    {
        $message = new ContactMessage([
            'name' => 'Runtime Test',
            'email' => 'runtime@example.com',
            'message' => 'This verifies the real mailable rendering path.',
        ]);

        Mail::to('info@rolandaga.com')->send(new ContactMessageReceived($message));

        $this->assertStringContainsString('New portfolio enquiry', (new ContactMessageReceived($message))->render());
    }

    public function test_portfolio_assets_are_available(): void
    {
        $this->assertFileExists(public_path('styles.css'));
        $this->assertFileExists(public_path('script.js'));
        $this->assertFileExists(public_path('assets/wallpaper/roland-portfolio.png'));
        $this->assertFileExists(public_path('assets/desktop/about.webp'));
        $this->assertFileExists(public_path('assets/taskbar/start-button.webp'));
        $this->assertFileExists(public_path('assets/fonts/tahoma.woff2'));
        $this->assertFileExists(public_path('assets/boot/loading.webp'));
        $this->assertFileExists(public_path('assets/boot/boot-wordmark.webp'));
        $this->assertFileExists(public_path('assets/sounds/login.wav'));
        $this->assertFileExists(public_path('assets/sounds/logoff.wav'));
        $this->assertFileExists(public_path('assets/profile/roland-cartoon.png'));
    }
}
