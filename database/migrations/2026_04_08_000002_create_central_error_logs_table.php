<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('central_error_logs', function (Blueprint $table): void {
            $table->id();
            $table->string('tenant_key')->nullable()->index();
            $table->timestamp('occurred_at')->index();
            $table->string('environment')->index();
            $table->string('service_name')->index();
            $table->string('severity')->default('error')->index();
            $table->uuid('request_id')->nullable()->index();
            $table->uuid('trace_id')->nullable()->index();
            $table->string('span_id')->nullable()->index();
            $table->string('route')->nullable()->index();
            $table->string('method', 10)->nullable();
            $table->unsignedSmallInteger('status_code')->nullable()->index();
            $table->text('message');
            $table->string('exception_class')->nullable()->index();
            $table->string('error_code')->nullable()->index();
            $table->text('file_path')->nullable();
            $table->unsignedInteger('line_number')->nullable();
            $table->longText('stack_trace')->nullable();
            $table->json('context')->nullable();
            $table->string('fingerprint', 64)->index();
            $table->boolean('handled')->default(false)->index();
            $table->string('release_version')->nullable()->index();
            $table->string('hostname')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('central_error_logs');
    }
};
