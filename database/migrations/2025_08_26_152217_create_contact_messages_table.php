<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name', 120);
            $t->string('email', 150);
            $t->string('phone', 50)->nullable();
            $t->string('subject', 200)->nullable();
            $t->text('message');
            $t->boolean('is_read')->default(false);
            $t->string('meta_ip', 64)->nullable();
            $t->string('meta_ua', 255)->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
