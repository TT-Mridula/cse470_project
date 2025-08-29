<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('headline')->nullable();
            $t->text('summary')->nullable();             // resume summary
            $t->string('location')->nullable();
            $t->string('website')->nullable();
            $t->string('github')->nullable();
            $t->string('linkedin')->nullable();
            $t->timestamps();
            $t->unique('user_id');
        });
    }
    public function down(): void { Schema::dropIfExists('user_profiles'); }
};

