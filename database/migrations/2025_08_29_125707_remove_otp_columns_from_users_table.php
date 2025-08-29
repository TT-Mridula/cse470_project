<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'login_otp')) $table->dropColumn('login_otp');
            if (Schema::hasColumn('users', 'login_otp_expires_at')) $table->dropColumn('login_otp_expires_at');
            if (Schema::hasColumn('users', 'login_otp_attempts')) $table->dropColumn('login_otp_attempts');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('login_otp')->nullable();
            $table->dateTime('login_otp_expires_at')->nullable();
            $table->unsignedTinyInteger('login_otp_attempts')->default(0);
        });
    }
};
