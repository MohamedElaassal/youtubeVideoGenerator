<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nController extends Controller
{
    /**
     * Generate script using Gemini AI
     */
    public function generateScript(Request $request, $videoId): JsonResponse
    {
        try {
            $video = Video::findOrFail($videoId);

            $prompt = "Create an engaging YouTube script about: {$request->topic}. Target duration: {$request->duration} minutes. Include: 1) Catchy intro hook, 2) Clear structure with 3-5 main points, 3) Engaging examples and stories, 4) Strong conclusion with call-to-action. Write in conversational, enthusiastic tone. Make it informative yet entertaining.";

            $response = Http::timeout(30)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent', [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ], [
                'key' => config('services.gemini.api_key')
            ]);

            if ($response->successful()) {
                $script = $response->json()['candidates'][0]['content']['parts'][0]['text'];

                $video->update([
                    'script' => $script,
                    'status' => 'script_generated'
                ]);

                return response()->json([
                    'success' => true,
                    'script' => $script,
                    'video_id' => $videoId
                ]);
            }

            throw new \Exception('Failed to generate script');

        } catch (\Exception $e) {
            Log::error('Script generation failed', ['error' => $e->getMessage(), 'video_id' => $videoId]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate script',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch media from Pixabay and Unsplash
     */
    public function fetchMedia(Request $request, $videoId): JsonResponse
    {
        try {
            $video = Video::findOrFail($videoId);
            $topic = $request->topic;
            $mediaList = [];

            // Fetch videos from Pixabay
            $pixabayResponse = Http::get('https://pixabay.com/api/videos/', [
                'key' => config('services.pixabay.api_key'),
                'q' => str_replace(' ', '+', $topic),
                'video_type' => 'film',
                'category' => 'backgrounds',
                'min_duration' => 20,
                'per_page' => 8,
                'safesearch' => 'true'
            ]);

            if ($pixabayResponse->successful()) {
                $videos = $pixabayResponse->json()['hits'] ?? [];
                foreach (array_slice($videos, 0, 3) as $video) {
                    $videoUrl = $video['videos']['medium']['url'] ?? $video['videos']['small']['url'] ?? null;
                    if ($videoUrl) {
                        $mediaList[] = [
                            'type' => 'video',
                            'url' => $videoUrl,
                            'duration' => $video['duration'] ?? 30
                        ];
                    }
                }
            }

            // Fetch images from Unsplash
            $unsplashResponse = Http::withHeaders([
                'Authorization' => 'Client-ID ' . config('services.unsplash.access_key')
            ])->get('https://api.unsplash.com/search/photos', [
                'query' => $topic,
                'per_page' => 10,
                'orientation' => 'landscape'
            ]);

            if ($unsplashResponse->successful()) {
                $images = $unsplashResponse->json()['results'] ?? [];
                foreach (array_slice($images, 0, 5) as $image) {
                    if ($image['urls']['regular']) {
                        $mediaList[] = [
                            'type' => 'image',
                            'url' => $image['urls']['regular']
                        ];
                    }
                }
            }

            $video->update([
                'status' => 'media_fetched'
            ]);

            return response()->json([
                'success' => true,
                'media_list' => $mediaList,
                'video_id' => $videoId
            ]);

        } catch (\Exception $e) {
            Log::error('Media fetch failed', ['error' => $e->getMessage(), 'video_id' => $videoId]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch media',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload video to YouTube using user's OAuth token
     */
    public function uploadToYoutube(Request $request, $videoId): JsonResponse
    {
        try {
            $video = Video::with('user')->findOrFail($videoId);

            // Check if user has YouTube OAuth token
            if (!$video->user->youtube_access_token) {
                return response()->json([
                    'success' => false,
                    'message' => 'User has not connected YouTube account'
                ], 400);
            }

            // Refresh token if needed
            if ($video->user->youtube_token_expires_at && $video->user->youtube_token_expires_at->isPast()) {
                $this->refreshYouTubeToken($video->user);
            }

            // Upload to YouTube
            $youtubeResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $video->user->youtube_access_token,
                'Content-Type' => 'application/json'
            ])->post('https://www.googleapis.com/upload/youtube/v3/videos?part=snippet,status&uploadType=resumable', [
                'snippet' => [
                    'title' => $video->title ?: ($request->topic . ' - AI Generated Video'),
                    'description' => $video->description ?: "This video was automatically generated using AI.\n\nScript generated by Google Gemini AI\nMedia from Pixabay and Unsplash\nVoiceover by Google Text-to-Speech\n\n#AI #{$request->topic} #AutoGenerated",
                    'tags' => explode(',', $video->tags ?: 'AI,Automated,Technology'),
                    'categoryId' => '28'
                ],
                'status' => [
                    'privacyStatus' => 'public'
                ]
            ]);

            if ($youtubeResponse->successful()) {
                $youtubeVideoId = $youtubeResponse->json()['id'];
                $youtubeUrl = "https://www.youtube.com/watch?v={$youtubeVideoId}";

                $video->update([
                    'youtube_video_id' => $youtubeVideoId,
                    'youtube_url' => $youtubeUrl,
                    'status' => 'uploaded'
                ]);

                return response()->json([
                    'success' => true,
                    'youtube_video_id' => $youtubeVideoId,
                    'youtube_url' => $youtubeUrl
                ]);
            }

            throw new \Exception('YouTube upload failed');

        } catch (\Exception $e) {
            Log::error('YouTube upload failed', ['error' => $e->getMessage(), 'video_id' => $videoId]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload to YouTube',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh YouTube OAuth token
     */
    private function refreshYouTubeToken(User $user): void
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $user->youtube_refresh_token,
            'grant_type' => 'refresh_token'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $user->update([
                'youtube_access_token' => $data['access_token'],
                'youtube_token_expires_at' => now()->addSeconds($data['expires_in'])
            ]);
        }
    }
    /**
     * Get video details for n8n workflow
     */
    public function getVideoDetails(Request $request, $videoId): JsonResponse
    {
        $video = Video::with('user')->findOrFail($videoId);

        return response()->json([
            'id' => $video->id,
            'title' => $video->title,
            'description' => $video->description,
            'tags' => explode(',', $video->tags ?? ''),
            'script' => $video->script,
            'status' => $video->status,
            'user_id' => $video->user_id,
            'api_token' => $video->user->createToken('n8n-api')->plainTextToken
        ]);
    }

    /**
     * Update video status from n8n
     */
    public function updateVideoStatus(Request $request, $videoId): JsonResponse
    {
        $video = Video::findOrFail($videoId);

        $video->update([
            'status' => $request->status,
            'file_path' => $request->file_path,
            'script' => $request->script ?? $video->script,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video status updated',
            'video' => $video
        ]);
    }

    /**
     * Mark video as uploaded to YouTube
     */
    public function markAsUploaded(Request $request, $videoId): JsonResponse
    {
        $video = Video::findOrFail($videoId);

        $video->update([
            'status' => 'uploaded',
            'youtube_video_id' => $request->youtube_video_id,
            'youtube_url' => $request->youtube_url,
            'uploaded_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video marked as uploaded',
            'video' => $video
        ]);
    }

    /**
     * Get scheduled topics for autopilot
     */
    public function getScheduledTopics(Request $request): JsonResponse
    {
        // Get videos that are scheduled for today and haven't been processed
        $scheduledVideos = Video::where('status', 'scheduled')
            ->whereDate('scheduled_at', today())
            ->with('user')
            ->get();

        $topics = $scheduledVideos->map(function ($video) {
            return [
                'video_id' => $video->id,
                'topic' => $video->title,
                'duration' => $video->duration ?? 5,
                'api_token' => $video->user->createToken('autopilot-api')->plainTextToken,
                'youtube_access_token' => $video->user->google_access_token,
                'youtube_api_key' => config('services.google.api_key')
            ];
        });

        return response()->json($topics);
    }

    /**
     * Create a new video request from n8n
     */
    public function createVideoRequest(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1|max:60'
        ]);

        $video = Video::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration ?? 5,
            'status' => 'processing',
            'created_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'video_id' => $video->id,
            'message' => 'Video request created'
        ], 201);
    }
}
