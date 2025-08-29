<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'otp_code')) {
                $table->string('otp_code', 10)->nullable()->after('remember_token');
            }
            if (! Schema::hasColumn('users', 'otp_expires_at')) {
                $table->dateTime('otp_expires_at')->nullable()->after('otp_code');
            }
            if (! Schema::hasColumn('users', 'otp_attempts')) {
                $table->unsignedTinyInteger('otp_attempts')->default(0)->after('otp_expires_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'otp_attempts')) $table->dropColumn('otp_attempts');
            if (Schema::hasColumn('users', 'otp_expires_at')) $table->dropColumn('otp_expires_at');
            if (Schema::hasColumn('users', 'otp_code')) $table->dropColumn('otp_code');
            if (Schema::hasColumn('users', 'phone')) $table->dropColumn('phone');
        });
    }
};
