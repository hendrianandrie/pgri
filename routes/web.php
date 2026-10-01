<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaktiController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSaktiController;
use App\Http\Controllers\Admin\AdminExecutiveController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// SAKTI Navigation
Route::prefix('sakti')->name('sakti.')->group(function () {
    Route::get('/', [SaktiController::class, 'index'])->name('index');
    Route::get('/pembelajaran-mendalam', [SaktiController::class, 'pembelajaranMendalam'])->name('pembelajaran-mendalam');
    Route::get('/rumah-pendidikan', [SaktiController::class, 'rumahPendidikan'])->name('rumah-pendidikan');
    Route::get('/pid', [SaktiController::class, 'pid'])->name('pid');
    Route::get('/koding-kka', [SaktiController::class, 'kodingKka'])->name('koding-kka');
    Route::get('/modul/{slug}', [SaktiController::class, 'show'])->name('show');
});

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Sakti Management - Separated by Pillar
    Route::get('/sakti', [AdminSaktiController::class, 'index'])->name('sakti.index');
    Route::get('/sakti/pembelajaran-mendalam', [AdminSaktiController::class, 'pembelajaranMendalam'])->name('sakti.pembelajaran-mendalam');
    Route::get('/sakti/rumah-pendidikan', [AdminSaktiController::class, 'rumahPendidikan'])->name('sakti.rumah-pendidikan');
    Route::get('/sakti/pid', [AdminSaktiController::class, 'pid'])->name('sakti.pid');
    Route::get('/sakti/koding-kka', [AdminSaktiController::class, 'kodingKka'])->name('sakti.koding-kka');
    Route::get('/sakti/{id}/edit', [AdminSaktiController::class, 'edit'])->name('sakti.edit');
    Route::put('/sakti/{id}', [AdminSaktiController::class, 'update'])->name('sakti.update');
    Route::post('/sakti', [AdminSaktiController::class, 'store'])->name('sakti.store');
    Route::delete('/sakti/{id}', [AdminSaktiController::class, 'destroy'])->name('sakti.destroy');

    // Executives Management
    Route::get('/executives', [AdminExecutiveController::class, 'index'])->name('executives.index');
    Route::post('/executives', [AdminExecutiveController::class, 'store'])->name('executives.store');
    Route::put('/executives/{id}', [AdminExecutiveController::class, 'update'])->name('executives.update');
    Route::delete('/executives/{id}', [AdminExecutiveController::class, 'destroy'])->name('executives.destroy');

    // Testimonials Management
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [AdminTestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{id}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{id}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // News / Reportage Management
    Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [AdminNewsController::class, 'create'])->name('news.create');
    Route::post('/news', [AdminNewsController::class, 'store'])->name('news.store');
    Route::get('/news/{id}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [AdminNewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');

    // Gallery Management
    Route::get('/galleries', [AdminGalleryController::class, 'index'])->name('galleries.index');
    Route::post('/galleries', [AdminGalleryController::class, 'store'])->name('galleries.store');
    Route::put('/galleries/{id}', [AdminGalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/galleries/{id}', [AdminGalleryController::class, 'destroy'])->name('galleries.destroy');

    // Messages / Aspirasi Management
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{id}/toggle-read', [AdminMessageController::class, 'toggleRead'])->name('messages.toggleRead');
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Hero Banner Settings
    Route::get('/hero-settings', [AdminSettingController::class, 'heroSettings'])->name('hero-settings');
    Route::post('/hero-settings', [AdminSettingController::class, 'updateHeroSettings'])->name('hero-settings.update');

    // Contact & Office Settings
    Route::get('/contact-settings', [AdminSettingController::class, 'contactSettings'])->name('contact-settings');
    Route::post('/contact-settings', [AdminSettingController::class, 'updateContactSettings'])->name('contact-settings.update');

    // Account Management (Admin, Pengurus, Guru)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
});


// Direct Storage File Fallback for Hosting
Route::get('/storage/{path}', function ($filePath) {
    $fullPath = storage_path('app/public/' . $filePath);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');

Route::get('/debug-storage', function () {
    $storagePublic = storage_path('app/public');
    $files = [];
    if (file_exists($storagePublic)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePublic));
        foreach ($iterator as $f) {
            if ($f->isFile()) {
                $files[] = str_replace($storagePublic . '/', '', $f->getPathname());
            }
        }
    }
    return response()->json([
        'storage_public_exists' => file_exists($storagePublic),
        'storage_public_writable' => is_writable($storagePublic),
        'storage_path' => $storagePublic,
        'public_path' => public_path(),
        'files_count' => count($files),
        'sample_files' => array_slice($files, 0, 20),
    ]);
});
