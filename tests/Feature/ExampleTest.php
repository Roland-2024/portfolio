<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_portfolio_page_is_rendered_from_laravel(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Roland OS | Portfolio')
            ->assertSee(asset('styles.css'), false)
            ->assertSee(asset('script.js'), false);
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
    }
}
