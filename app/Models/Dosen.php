<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nidn',
        'nama',
        'program_studi',
        'status_dosen',
        'foto',
    ];

    // Relasi 1:N dengan MataKuliah
    public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class);
    }

    // Relasi 1:N dengan Voting
    public function votings()
    {
        return $this->hasMany(Voting::class);
    }

    // Hitung total voting yang diterima
    public function getTotalVoting()
    {
        return $this->votings()->count();
    }

    // Hitung rata-rata nilai dari semua voting
    public function getRataRata()
    {
        return $this->votings()->avg('rata_rata') ?? 0;
    }

    // Dapatkan peringkat dosen
    public function getRanking()
    {
        $allDosen = Dosen::with('votings')->get();
        $sorted = $allDosen->sortByDesc(function ($dosen) {
            return $dosen->getRataRata();
        });

        return $sorted->search(function ($item) {
            return $item->id === $this->id;
        }) + 1;
    }

    // Kategori berdasarkan rata-rata
    public function getKategori($rataRata = null)
    {
        $rata = $rataRata ?? $this->getRataRata();

        if ($rata >= 4.50) return 'Sangat Memuaskan';
        if ($rata >= 4.00) return 'Memuaskan';
        if ($rata >= 3.00) return 'Puas';
        if ($rata >= 2.00) return 'Cukup';
        return 'Tidak Puas';
    }
}
