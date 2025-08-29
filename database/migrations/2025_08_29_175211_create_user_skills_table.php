<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_skills', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->unsignedTinyInteger('level')->default(3);  // 1..5
            $t->timestamps();
            $t->unique(['user_id','name']);
        });
    }
    public function down(): void { Schema::dropIfExists('user_skills'); }
};
