<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Umum'); // Contoh: Regulasi, Matchday, Transfer
            $table->longText('content'); // longText agar muat banyak tulisan & gambar dari RichEditor
            $table->string('thumbnail')->nullable();
            
            // Status untuk mengontrol apakah berita sudah tayang atau masih draf
            $table->enum('status', ['draft', 'published'])->default('draft');
            
            // Fitur Pemulihan Bencana: Toggle untuk memunculkan banner darurat di Home Page
            $table->boolean('is_emergency')->default(false); 
            
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};