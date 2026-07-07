<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('username')->unique()->after('nama');
            $table->enum('role', ['admin', 'pimpinan', 'mahasiswa'])->default('mahasiswa')->after('email');
            $table->string('foto')->nullable()->after('role');
            $table->string('no_hp', 20)->nullable()->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama', 'username', 'role', 'foto', 'no_hp']);
        });
    }
};
