<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->enum('status', ['published', 'draft', 'hidden', 'banned'])->default('published');
            $table->timestamps();
            $table->index('user_id'); // Index cho query posts theo user
            $table->index('created_at'); // Index cho sort feed
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};