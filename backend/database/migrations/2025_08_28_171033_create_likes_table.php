<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['like', 'love', 'haha', 'angry', 'sad'])->default('like');
            $table->timestamps();
            $table->unique(['user_id', 'post_id']); // Ngăn duplicate likes
            $table->index('post_id'); // Index cho query likes theo post
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};