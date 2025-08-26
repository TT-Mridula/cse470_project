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
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->string('category')->nullable();          // eg. Web, ML, Mobile
        $table->string('image_path')->nullable();        // storage path
        $table->text('short_description')->nullable();
        $table->longText('long_description')->nullable();
        $table->string('github_url')->nullable();
        $table->string('live_url')->nullable();
        $table->json('extra_links')->nullable();         // optional array of links
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
