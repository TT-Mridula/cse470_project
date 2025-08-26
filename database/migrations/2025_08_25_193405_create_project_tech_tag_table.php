<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('project_tech_tag', function (Blueprint $table) {
        $table->foreignId('project_id')->constrained()->cascadeOnDelete();
        $table->foreignId('tech_tag_id')->constrained()->cascadeOnDelete();
        $table->primary(['project_id','tech_tag_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tech_tag');
    }
};
