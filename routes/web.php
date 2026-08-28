<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\RegisterController; // Disabled - single user only
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ─── Public ──────────────────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\TrackVisitor::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
});
Route::post('/contact/send', [HomeController::class, 'sendContact'])->name('contact.send');

Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::where('is_published', true)->latest()->get();
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    // Home
    $xml .= '<url><loc>' . url('/') . '</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>';
    // Blog Index
    $xml .= '<url><loc>' . url('/blog') . '</loc><changefreq>daily</changefreq><priority>0.8</priority></url>';
    
    // Blog Posts
    foreach ($posts as $post) {
        $xml .= '<url>';
        $xml .= '<loc>' . url('/blog/' . $post->slug) . '</loc>';
        $xml .= '<lastmod>' . $post->updated_at->tz('UTC')->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>monthly</changefreq>';
        $xml .= '<priority>0.6</priority>';
        $xml .= '</url>';
    }
    
    $xml .= '</urlset>';
    
    return response($xml)->header('Content-Type', 'text/xml');
});

// ─── Authentication ──────────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register routes disabled (single user portfolio) - re-enable when needed
Route::get('/register', function() { abort(404); })->name('register');
Route::post('/register', function() { abort(404); });

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// ─── Admin (auth-protected) ─────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visitors', [\App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('visitors.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Site Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Drag & Drop Reorder
    Route::post('portfolios/reorder', [PortfolioController::class, 'reorder'])->name('portfolios.reorder');
    Route::post('skills/reorder', [SkillController::class, 'reorder'])->name('skills.reorder');
    Route::post('experiences/reorder', [ExperienceController::class, 'reorder'])->name('experiences.reorder');
    Route::post('social-links/reorder', [SocialLinkController::class, 'reorder'])->name('social-links.reorder');

    // Resource Routes
    Route::resource('portfolios', PortfolioController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::post('posts/upload-image', [\App\Http\Controllers\Admin\PostController::class, 'uploadImage'])->name('posts.upload_image');
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('social-links', SocialLinkController::class)->parameters([
        'social-links' => 'socialLink',
    ]);
});

Route::get('/migrate-db', function () {
    try {
        // PostgreSQL: drop and recreate public schema (clean slate)
        \Illuminate\Support\Facades\DB::statement('DROP SCHEMA public CASCADE');
        \Illuminate\Support\Facades\DB::statement('CREATE SCHEMA public');

        // Now run migrations and seeders
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--seed' => true, '--force' => true]);
        return 'Database migrated successfully! ' . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Throwable $e) {
        return 'Error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ':' . $e->getLine();
    }
});
