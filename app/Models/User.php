<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_access_token',
        'google_refresh_token',
        'google_token_expires_at',
        'google_scopes',
        'avatar_url',
        'youtube_access_token',
        'youtube_refresh_token',
        'youtube_token_expires_at',
        'subscription_plan',
        'monthly_video_quota',
        'videos_generated_this_month',
        'quota_reset_at',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'google_scopes' => 'array',
        'google_token_expires_at' => 'datetime',
        'quota_reset_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function youtubeChannels(): HasMany
    {
        return $this->hasMany(YoutubeChannel::class);
    }

    public function videoGenerations(): HasMany
    {
        return $this->hasMany(VideoGeneration::class);
    }

    public function canGenerateVideo(): bool
    {
        // Reset quota if it's a new month
        if ($this->quota_reset_at && $this->quota_reset_at->isBefore(now()->startOfMonth())) {
            $this->update([
                'videos_generated_this_month' => 0,
                'quota_reset_at' => now()->endOfMonth(),
            ]);
        }

        return $this->videos_generated_this_month < $this->monthly_video_quota;
    }

    public function hasValidGoogleToken(): bool
    {
        return $this->google_access_token &&
               $this->google_token_expires_at &&
               $this->google_token_expires_at->isFuture();
    }
}
