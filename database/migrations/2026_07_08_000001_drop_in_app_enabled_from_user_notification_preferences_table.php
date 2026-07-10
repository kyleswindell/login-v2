<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('user_notification_preferences', 'in_app_enabled')) {
            return;
        }

        Schema::table('user_notification_preferences', function (Blueprint $table): void {
            $table->dropColumn('in_app_enabled');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('user_notification_preferences', 'in_app_enabled')) {
            return;
        }

        Schema::table('user_notification_preferences', function (Blueprint $table): void {
            $table->boolean('in_app_enabled')->default(true);
        });
    }
};
