<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim', 20)->unique();
            $table->string('nama', 100);
            $table->string('program_studi', 50);
            $table->integer('semester')->default(1);
            $table->string('kelas', 10)->nullable();
            $table->enum('status_voting', ['Belum', 'Sudah'])->default('Belum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
