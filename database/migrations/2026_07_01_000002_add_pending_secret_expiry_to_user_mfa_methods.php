<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_mfa_methods', function (Blueprint $table): void {
            $table->timestamp('pending_secret_expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('user_mfa_methods', function (Blueprint $table): void {
            $table->dropColumn('pending_secret_expires_at');
        });
    }
};
