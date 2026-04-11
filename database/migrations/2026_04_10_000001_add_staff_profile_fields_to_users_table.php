<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->decimal('hourly_rate', 10, 2)->default(0)->after('timezone');
            $table->string('phone', 50)->nullable()->after('hourly_rate');
            $table->string('facebook', 255)->nullable()->after('phone');
            $table->string('linkedin', 255)->nullable()->after('facebook');
            $table->string('skype', 255)->nullable()->after('linkedin');
            $table->string('default_language', 10)->nullable()->after('skype');
            $table->text('email_signature')->nullable()->after('default_language');
            $table->string('direction', 5)->default('ltr')->after('email_signature');
            $table->boolean('send_welcome_email')->default(false)->after('direction');
            $table->boolean('is_administrator')->default(false)->after('send_welcome_email');
            $table->boolean('is_staff_member')->default(true)->after('is_administrator');
            $table->string('profile_image_path')->nullable()->after('is_staff_member');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'first_name',
                'last_name',
                'hourly_rate',
                'phone',
                'facebook',
                'linkedin',
                'skype',
                'default_language',
                'email_signature',
                'direction',
                'send_welcome_email',
                'is_administrator',
                'is_staff_member',
                'profile_image_path',
            ]);
        });
    }
};
