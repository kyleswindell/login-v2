<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_audit_logs', function (Blueprint $table): void {
            $table->id();
            $table->timestamp('occurred_at')->index();
            $table->string('event_type')->index();
            $table->string('action')->index();
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('actor_type')->nullable()->index();
            $table->string('actor_id')->nullable()->index();
            $table->string('subject_type')->nullable()->index();
            $table->string('subject_id')->nullable()->index();
            $table->string('result')->default('success')->index();
            $table->string('severity')->default('info')->index();
            $table->uuid('request_id')->nullable()->index();
            $table->uuid('trace_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('route')->nullable()->index();
            $table->string('method', 10)->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_system_event')->default(false)->index();
            $table->boolean('is_security_event')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_audit_logs');
    }
};
