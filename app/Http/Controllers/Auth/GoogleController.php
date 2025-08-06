<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\YoutubeChannel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        // Check if Google OAuth is configured
        if (!config('services.google.client_id') || config('services.google.client_id') === 'your_google_client_id_here') {
            return redirect('/login')->with('error', 'Google OAuth is not configured. Please set up your Google OAuth credentials in the .env file.');
        }

        // Force a full page redirect (not Inertia.js)
        return redirect()->away(Socialite::driver('google')->redirect()->getTargetUrl());
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar_url' => $googleUser->avatar,
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'google_token_expires_at' => now()->addSeconds($googleUser->expiresIn ?? 3600),
                'google_scopes' => $googleUser->approvedScopes ?? [],
            ]);

            Auth::login($user);

            // TODO: Fetch and store YouTube channel information
            // $this->syncYouTubeChannels($user);

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Authentication failed. Please try again.');
        }
    }

    protected function syncYouTubeChannels(User $user): void
    {
        // TODO: Implement YouTube channel sync when Google API client is installed
        // For now, just log that we would sync channels
        Log::info('YouTube channel sync would happen here for user: ' . $user->id);

        /*
        try {
            $client = new Google_Client();
            $client->setAccessToken($user->google_access_token);

            $youtube = new Google_Service_YouTube($client);
            $channels = $youtube->channels->listChannels('snippet,statistics', [
                'mine' => true
            ]);

            foreach ($channels->getItems() as $channel) {
                YoutubeChannel::updateOrCreate([
                    'user_id' => $user->id,
                    'youtube_channel_id' => $channel->getId(),
                ], [
                    'channel_title' => $channel->getSnippet()->getTitle(),
                    'channel_description' => $channel->getSnippet()->getDescription(),
                    'thumbnail_url' => $channel->getSnippet()->getThumbnails()->getDefault()->getUrl(),
                    'subscriber_count' => $channel->getStatistics()->getSubscriberCount() ?? 0,
                    'video_count' => $channel->getStatistics()->getVideoCount() ?? 0,
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't fail the authentication
            Log::error('Failed to sync YouTube channels: ' . $e->getMessage());
        }
        */
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
