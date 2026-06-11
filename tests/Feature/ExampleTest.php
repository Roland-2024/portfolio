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
            ->assertSee('Roland Aga | Full Stack Software Developer Portfolio')
            ->assertSee('Roland Aga')
            ->assertSee('Full Stack Software Developer')
            ->assertSee('info@rolandaga.com')
            ->assertSee('1UP LABS')
            ->assertSee('Municipality of Tirana')
            ->assertSee('MediGreen Pharmacy E-commerce Website with Odoo Integration')
            ->assertSee('https://medigreen.al/', false)
            ->assertSee(asset('assets/projects/medigreen-mockup.webp'), false)
            ->assertSee('FirstStore.al - WooCommerce E-commerce Platform')
            ->assertSee('https://firststore.al/', false)
            ->assertSee(asset('assets/projects/firststore-mockup.webp'), false)
            ->assertSee('Custom WordPress Website for UK Accounting Firm (AL-TAX LTD)')
            ->assertSee('https://al-tax.co.uk/', false)
            ->assertSee(asset('assets/projects/al-tax-mockup.webp'), false)
            ->assertSee('Euronews Albania')
            ->assertSee('https://euronews.al/', false)
            ->assertSee(asset('assets/projects/euronews-albania-mockup.webp'), false)
            ->assertSee('Football Betting Tips & Predictions Website')
            ->assertSee('https://betprofe.com/', false)
            ->assertSee(asset('assets/projects/betprofe-mockup.webp'), false)
            ->assertSee('DasWeltAuto - Certified Used Cars Platform (Albania)')
            ->assertSee('https://dasweltauto.al/', false)
            ->assertSee(asset('assets/projects/dasweltauto-mockup.webp'), false)
            ->assertSee('https://www.linkedin.com/in/roland-aga-a74906146/', false)
            ->assertSee(asset('assets/profile/roland-cartoon.png'), false)
            ->assertSee('All Programs')
            ->assertSee('all-programs-menu')
            ->assertSee('roland://about')
            ->assertSee('roland://projects')
            ->assertSee('Music Player window')
            ->assertSee('Media Player window')
            ->assertSee(asset('assets/sounds/juve.mp3'), false)
            ->assertSee('data-video-id="1x9ohaOSi0k"', false)
            ->assertSee('referrerpolicy="strict-origin-when-cross-origin"', false)
            ->assertSee('Paint window')
            ->assertSee('Minesweeper game window')
            ->assertSee('Beginner: 9 × 9 board, 10 mines')
            ->assertSee('data-open="minesweeper"', false)
            ->assertSee('desktop-icon-label">Minesweeper', false)
            ->assertSee(asset('assets/start-menu/minesweeper.svg'), false)
            ->assertSee('JSON Studio developer tool window')
            ->assertSee('data-open="jsonstudio"', false)
            ->assertSee('desktop-icon-label">JSON Studio', false)
            ->assertSee('data-json-action="format"', false)
            ->assertSee('data-json-action="minify"', false)
            ->assertSee('data-json-action="validate"', false)
            ->assertSee(asset('assets/start-menu/json-studio.svg'), false)
            ->assertSee('Command Prompt window')
            ->assertSee('desktop-icon-label">Command Prompt', false)
            ->assertSee('Image Viewer window')
            ->assertSee('data-menu="file"', false)
            ->assertSee('data-project-search', false)
            ->assertSee('loading="lazy"', false)
            ->assertSee('decoding="async"', false)
            ->assertSee('Euronews Albania responsive website mockup')
            ->assertSee("Roland's Portfolio displayed across a Windows XP-inspired green hill", false)
            ->assertSee(asset('assets/wallpaper/roland-portfolio.webp'), false)
            ->assertSee('application/ld+json', false)
            ->assertSee('schema.org', false)
            ->assertSee('fullscreen-toggle')
            ->assertSee(asset('assets/favicon-ra-shade.png'), false)
            ->assertSee(asset('styles.css'), false)
            ->assertSee(asset('script.js'), false);

        $response->assertSeeInOrder([
            'MediGreen Pharmacy E-commerce Website with Odoo Integration',
            'FirstStore.al - WooCommerce E-commerce Platform',
            'Custom WordPress Website for UK Accounting Firm (AL-TAX LTD)',
            'Euronews Albania',
            'DasWeltAuto - Certified Used Cars Platform (Albania)',
            'Football Betting Tips & Predictions Website',
        ]);

        $response
            ->assertDontSee('Custom Business Systems')
            ->assertDontSee('WordPress & WooCommerce')
            ->assertDontSee('Scalable Integrations')
            ->assertDontSee('Deployment & Optimization');
    }

    public function test_dashboard_requires_authentication_and_admin_can_log_in(): void
    {
        $admin = User::factory()->create(['email' => 'admin@example.com', 'password' => 'secret-password']);

        $this->get('/admin')->assertRedirect('/admin/login');

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'secret-password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/admin')->assertOk()->assertSee('Manage the content shown on your portfolio.');
    }

    public function test_responses_include_security_headers(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_admin_login_is_rate_limited(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/admin/login', ['email' => 'admin@example.com', 'password' => 'incorrect'])
                ->assertSessionHasErrors('email');
        }

        $this->post('/admin/login', ['email' => 'admin@example.com', 'password' => 'incorrect'])
            ->assertTooManyRequests();
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
        $this->assertFileExists(public_path('assets/wallpaper/roland-portfolio.webp'));
        $this->assertFileDoesNotExist(public_path('assets/wallpaper/roland-portfolio.png'));
        $this->assertFileExists(public_path('assets/desktop/about.webp'));
        $this->assertFileExists(public_path('assets/taskbar/start-button.webp'));
        $this->assertFileExists(public_path('assets/fonts/tahoma.woff2'));
        $this->assertFileExists(public_path('assets/boot/loading.webp'));
        $this->assertFileExists(public_path('assets/boot/boot-wordmark.webp'));
        $this->assertFileExists(public_path('assets/sounds/login.wav'));
        $this->assertFileExists(public_path('assets/sounds/logoff.wav'));
        $this->assertFileExists(public_path('assets/sounds/juve.mp3'));
        $this->assertFileExists(public_path('assets/profile/roland-cartoon.png'));
        $this->assertFileExists(public_path('assets/favicon-ra-shade.png'));
        $this->assertFileExists(public_path('assets/start-menu/minesweeper.svg'));
        $this->assertFileExists(public_path('assets/start-menu/json-studio.svg'));
        $this->assertFileExists(public_path('assets/projects/medigreen-mockup.webp'));
        $this->assertFileExists(public_path('assets/projects/firststore-mockup.webp'));
        $this->assertFileExists(public_path('assets/projects/al-tax-mockup.webp'));
        $this->assertFileExists(public_path('assets/projects/betprofe-mockup.webp'));
        $this->assertFileExists(public_path('assets/projects/dasweltauto-mockup.webp'));
        $this->assertFileExists(public_path('assets/projects/euronews-albania-mockup.webp'));
    }
}
