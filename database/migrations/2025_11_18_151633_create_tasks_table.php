<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel todolists
            $table->foreignId('todolist_id')
                ->constrained('todolists')
                ->onDelete('cascade');

            $table->string('nama'); // nama task
            $table->boolean('status')->default(false); // 0 = belum selesai, 1 = selesai

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
