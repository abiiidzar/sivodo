<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained()->onDelete('cascade');
            $table->foreignId('mata_kuliah_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->integer('total_skor')->default(0);
            $table->decimal('rata_rata', 3, 2)->default(0.00);
            $table->text('kritik')->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();

            // UNIQUE: 1 mahasiswa × 1 mata kuliah × 1 semester
            $table->unique(['mahasiswa_id', 'mata_kuliah_id', 'semester_id'], 'unique_voting');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votings');
    }
};
