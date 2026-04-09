<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->morphs('notifiable');
            $table->string('module_key')->index();
            $table->string('severity')->default('info')->index();
            $table->string('title');
            $table->text('body');
            $table->string('action_url')->nullable();
            $table->timestamp('read_at')->nullable()->index();
            $table->timestamp('dismissed_at')->nullable()->index();
            // Delivery metadata stays on the row in Phase 1 so we can support future
            // channels without introducing receipt/fan-out tables before they are needed.
            $table->json('delivery_channels')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
