<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'pertanyaan',
        'urutan',
        'status',
    ];

    // Relasi 1:N dengan VotingDetail
    public function votingDetails()
    {
        return $this->hasMany(VotingDetail::class);
    }

    // Scope untuk pertanyaan aktif
    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }

    // Ambil semua pertanyaan aktif urut
    public static function getPertanyaanAktif()
    {
        return self::where('status', true)
            ->orderBy('urutan')
            ->get();
    }
}
