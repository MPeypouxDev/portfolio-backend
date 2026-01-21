<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('github_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->date('date_realisation');
            $table->foreignId('author_id')->constrained('users')->onDelete('restrict');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('order');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
