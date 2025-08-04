<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('remember_token');
            $table->text('google_access_token')->nullable()->after('google_id');
            $table->text('google_refresh_token')->nullable()->after('google_access_token');
            $table->timestamp('google_token_expires_at')->nullable()->after('google_refresh_token');
            $table->json('google_scopes')->nullable()->after('google_token_expires_at');
            $table->string('avatar_url')->nullable()->after('google_scopes');
            $table->text('youtube_access_token')->nullable()->after('avatar_url');
            $table->text('youtube_refresh_token')->nullable()->after('youtube_access_token');
            $table->timestamp('youtube_token_expires_at')->nullable()->after('youtube_refresh_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'google_access_token',
                'google_refresh_token',
                'google_token_expires_at',
                'google_scopes',
                'avatar_url',
                'youtube_access_token',
                'youtube_refresh_token',
                'youtube_token_expires_at',
            ]);
        });
    }
};
