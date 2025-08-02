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
            $table->text('youtube_access_token')->nullable()->after('google_scopes');
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
                'youtube_access_token',
                'youtube_refresh_token',
                'youtube_token_expires_at'
            ]);
        });
    }
};
