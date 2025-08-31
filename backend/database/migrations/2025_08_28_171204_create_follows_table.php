<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['user_id', 'followed_id']); // Composite key
            $table->index('followed_id'); // Index cho query feed
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};