<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'mata_kuliah_id',
        'semester_id',
        'total_skor',
        'rata_rata',
        'kritik',
        'saran',
    ];

    // Relasi N:1 dengan Mahasiswa (inverse)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi N:1 dengan Dosen (inverse)
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Relasi N:1 dengan MataKuliah (inverse)
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    // Relasi N:1 dengan Semester (inverse)
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    // Relasi 1:N dengan VotingDetail
    public function votingDetails()
    {
        return $this->hasMany(VotingDetail::class);
    }

    // Hitung total skor otomatis
    public function hitungSkor()
    {
        $total = $this->votingDetails()->sum('nilai');
        $this->total_skor = $total;
        $this->rata_rata = round($total / $this->votingDetails()->count(), 2);
        $this->save();
    }

    // Dapatkan kategori
    public function getKategori()
    {
        $rata = $this->rata_rata;

        if ($rata >= 4.50) return 'Sangat Memuaskan';
        if ($rata >= 4.00) return 'Memuaskan';
        if ($rata >= 3.00) return 'Puas';
        if ($rata >= 2.00) return 'Cukup';
        return 'Tidak Puas';
    }

    // Cek unique voting
    public static function cekUniqueVoting($mahasiswaId, $mataKuliahId, $semesterId)
    {
        return self::where('mahasiswa_id', $mahasiswaId)
            ->where('mata_kuliah_id', $mataKuliahId)
            ->where('semester_id', $semesterId)
            ->exists();
    }
}
