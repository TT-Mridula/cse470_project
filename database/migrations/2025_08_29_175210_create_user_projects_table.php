<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_projects', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->string('slug')->nullable();              // optional
            $t->text('description')->nullable();
            $t->string('url')->nullable();
            $t->string('tech_stack')->nullable();        // comma list
            $t->date('started_at')->nullable();
            $t->date('ended_at')->nullable();
            $t->boolean('is_current')->default(false);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('user_projects'); }
};
