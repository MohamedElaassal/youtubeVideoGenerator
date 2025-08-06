<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\DemoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\YoutubeChannelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/login', function () {
    return Inertia::render('Auth/Login', [
        'error' => session('error')
    ]);
})->name('login');

// Google OAuth Routes
Route::prefix('auth/google')->middleware('cors')->group(function () {
    Route::get('/', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

// Demo Login Route (for testing without OAuth)
Route::get('/demo-login', [DemoController::class, 'loginDemo'])->name('demo.login');

Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', function (Request $request) {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => false,
            'status' => session('status'),
        ]);
    })->name('profile.edit');

    Route::patch('/profile', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    })->name('profile.update');

    // Video Management
    Route::resource('videos', VideoController::class);
    Route::post('/videos/{video}/upload', [VideoController::class, 'upload'])->name('videos.upload');

    // YouTube Channel Management
    Route::resource('youtube-channels', YoutubeChannelController::class);

    // API Routes for frontend
    Route::prefix('api')->group(function () {
        Route::get('/user', function (Request $request) {
            return response()->json($request->user());
        });

        Route::get('/videos/{video}/status', function (Request $request, $video) {
            $videoModel = $request->user()->videos()->findOrFail($video);
            return response()->json(['status' => $videoModel->status]);
        });
    });
});

// Admin Routes (will be implemented later)
// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     // Admin dashboard, user management, etc.
// });
