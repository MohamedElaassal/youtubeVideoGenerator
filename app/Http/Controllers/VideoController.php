<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoGeneration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request): Response
    {
        $videos = $request->user()
            ->videos()
            ->with('youtubeChannel')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Videos/Index', [
            'videos' => $videos
        ]);
    }

    public function create(): Response
    {
        $youtubeChannels = Auth::user()
            ->youtubeChannels()
            ->orderBy('channel_title')
            ->get();

        return Inertia::render('Videos/Create', [
            'youtubeChannels' => $youtubeChannels
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'youtube_channel_id' => 'nullable|exists:youtube_channels,id',
            'duration' => 'nullable|integer|min:30|max:600', // 30 seconds to 10 minutes
        ]);

        $user = $request->user();

        // Check if user can generate more videos this month
        if (!$user->canGenerateVideo()) {
            return back()->with('error', 'You have reached your monthly video generation limit.');
        }

        // Create video record
        $video = Video::create([
            'user_id' => $user->id,
            'youtube_channel_id' => $request->youtube_channel_id,
            'topic' => $request->topic,
            'title' => '', // Will be generated
            'status' => 'draft',
        ]);

        // Create generation job
        $jobId = Str::uuid();
        VideoGeneration::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'job_id' => $jobId,
            'topic' => $request->topic,
            'parameters' => [
                'duration' => $request->duration ?? 60,
                'style' => 'informative', // Default style
            ]
        ]);

        // Dispatch video generation job (will be implemented later)
        // GenerateVideoJob::dispatch($video, $jobId);

        // Update user's monthly count
        $user->increment('videos_generated_this_month');

        return redirect()->route('videos.show', $video)
            ->with('success', 'Video generation started! This may take a few minutes.');
    }

    public function show(Video $video): Response
    {
        $this->authorize('view', $video);

        $video->load('youtubeChannel');

        return Inertia::render('Videos/Show', [
            'video' => $video
        ]);
    }

    public function edit(Video $video): Response
    {
        $this->authorize('update', $video);

        $youtubeChannels = Auth::user()
            ->youtubeChannels()
            ->orderBy('channel_title')
            ->get();

        return Inertia::render('Videos/Create', [
            'video' => $video,
            'youtubeChannels' => $youtubeChannels
        ]);
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $this->authorize('update', $video);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'youtube_channel_id' => 'nullable|exists:youtube_channels,id',
        ]);

        $video->update($request->only(['title', 'description', 'youtube_channel_id']));

        return redirect()->route('videos.show', $video)
            ->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video): RedirectResponse
    {
        $this->authorize('delete', $video);

        // Only allow deletion if video is not processing
        if ($video->isProcessing()) {
            return back()->with('error', 'Cannot delete a video that is currently being processed.');
        }

        $video->delete();

        return redirect()->route('videos.index')
            ->with('success', 'Video deleted successfully.');
    }

    public function upload(Request $request, Video $video): RedirectResponse
    {
        $this->authorize('update', $video);

        if (!$video->isReady()) {
            return back()->with('error', 'Video is not ready for upload.');
        }

        if (!$video->youtubeChannel) {
            return back()->with('error', 'Please select a YouTube channel first.');
        }

        // Dispatch YouTube upload job (will be implemented later)
        // UploadToYouTubeJob::dispatch($video);

        $video->update(['status' => 'uploading']);

        return back()->with('success', 'Video upload started.');
    }
}
