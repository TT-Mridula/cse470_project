<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->string('login_otp', 6)->nullable();
            $t->timestamp('login_otp_expires_at')->nullable();
            $t->unsignedTinyInteger('login_otp_attempts')->default(0);
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['login_otp','login_otp_expires_at','login_otp_attempts']);
        });
    }
};
