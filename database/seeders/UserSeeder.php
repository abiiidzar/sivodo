<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nama' => 'Admin SIVODO',
            'username' => 'admin',
            'email' => 'admin@sivodo.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'foto' => null,
            'no_hp' => '081234567890',
        ]);

        // Pimpinan
        User::create([
            'nama' => 'Pimpinan SIVODO',
            'username' => 'pimpinan',
            'email' => 'pimpinan@sivodo.com',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
            'foto' => null,
            'no_hp' => '081234567891',
        ]);

        // Mahasiswa 1
        User::create([
            'nama' => 'Annisa Dwi Putri',
            'username' => 'annisa',
            'email' => 'annisa@sivodo.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'foto' => null,
            'no_hp' => '081234567892',
        ]);

        // Mahasiswa 2
        User::create([
            'nama' => 'Mohammad Raffi Dwika',
            'username' => 'raffi',
            'email' => 'raffi@sivodo.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'foto' => null,
            'no_hp' => '081234567893',
        ]);
        // Mahasiswa 3
        User::create([
            'nama' => 'Abidzar Al Ghiffari',
            'username' => 'abidzar',
            'email' => 'abidzar@sivodo.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'foto' => null,
            'no_hp' => '081234567893',
        ]);
        // Mahasiswa 4
        User::create([
            'nama' => 'Hafizah Faraz',
            'username' => 'ayaz',
            'email' => 'ayaz@sivodo.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'foto' => null,
            'no_hp' => '081234567893',
        ]);
        // Mahasiswa 5
        User::create([
            'nama' => 'Rindiani Fatika Sari',
            'username' => 'dian',
            'email' => 'dian@sivodo.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'foto' => null,
            'no_hp' => '081234567893',
        ]);
    }
}
