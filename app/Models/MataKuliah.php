<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'dosen_id',
        'kelas',
        'semester',
    ];

    // Relasi N:1 dengan Dosen (inverse)
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Relasi 1:N dengan Voting
    public function votings()
    {
        return $this->hasMany(Voting::class);
    }

    // Ambil dosen pengampu
    public function getDosenPengampu()
    {
        return $this->dosen;
    }
}
