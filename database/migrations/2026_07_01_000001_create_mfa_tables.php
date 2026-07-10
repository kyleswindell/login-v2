<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_mfa_methods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('totp');
            $table->text('secret')->nullable();
            $table->text('pending_secret')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('reset_at')->nullable();
            $table->foreignId('reset_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_challenged_at')->nullable();
            $table->timestamp('last_satisfied_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'type']);
            $table->index(['type', 'confirmed_at']);
        });

        Schema::create('user_mfa_policies', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('mfa_required')->default(false);
            $table->timestamp('required_at')->nullable();
            $table->foreignId('required_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique('user_id');
            $table->index('mfa_required');
        });

        Schema::create('mfa_recovery_codes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code_hash');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'used_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mfa_recovery_codes');
        Schema::dropIfExists('user_mfa_policies');
        Schema::dropIfExists('user_mfa_methods');
    }
};
