<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_id')->constrained()->onDelete('cascade');
            $table->foreignId('pertanyaan_id')->constrained()->onDelete('cascade');
            $table->integer('nilai')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voting_details');
    }
};
