<?php

use App\Http\Controllers\Api\N8nController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// n8n Integration Routes
Route::prefix('videos')->group(function () {
    Route::get('{video}/details', [N8nController::class, 'getVideoDetails']);
    Route::post('{video}/status', [N8nController::class, 'updateVideoStatus']);
    Route::post('{video}/generate-script', [N8nController::class, 'generateScript']);
    Route::post('{video}/fetch-media', [N8nController::class, 'fetchMedia']);
    Route::post('{video}/upload-youtube', [N8nController::class, 'uploadToYoutube']);
    Route::post('{video}/youtube-uploaded', [N8nController::class, 'markAsUploaded']);
});

Route::prefix('autopilot')->group(function () {
    Route::get('topics', [N8nController::class, 'getScheduledTopics']);
});

Route::post('video-requests', [N8nController::class, 'createVideoRequest']);
