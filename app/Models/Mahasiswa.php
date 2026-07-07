<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'program_studi',
        'semester',
        'kelas',
        'status_voting',
    ];

    // Relasi 1:1 dengan User (inverse)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi 1:N dengan Voting
    public function votings()
    {
        return $this->hasMany(Voting::class);
    }

    // Cek apakah sudah voting untuk mata kuliah tertentu
    public function cekStatusVoting($mataKuliahId, $semesterId)
    {
        return $this->votings()
            ->where('mata_kuliah_id', $mataKuliahId)
            ->where('semester_id', $semesterId)
            ->exists();
    }

    // Ambil daftar dosen berdasarkan semester aktif
    public function getDosenBySemester($semesterId)
    {
        return Dosen::whereHas('mataKuliahs', function ($query) use ($semesterId) {
            $query->whereHas('votings', function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            });
        })->get();
    }
}
