<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'voting_id',
        'pertanyaan_id',
        'nilai',
    ];

    // Relasi N:1 dengan Voting (inverse)
    public function voting()
    {
        return $this->belongsTo(Voting::class);
    }

    // Relasi N:1 dengan Pertanyaan (inverse)
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    // Konversi nilai ke teks
    public function getNilaiText()
    {
        $nilai = $this->nilai;
        $map = [
            1 => 'Sangat Kurang',
            2 => 'Kurang',
            3 => 'Cukup',
            4 => 'Baik',
            5 => 'Sangat Baik',
        ];

        return $map[$nilai] ?? 'Tidak Valid';
    }
}
