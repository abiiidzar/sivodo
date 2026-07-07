<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'status',
    ];

    // Relasi 1:N dengan Voting
    public function votings()
    {
        return $this->hasMany(Voting::class);
    }

    // Scope untuk semester aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    // Ambil semester aktif
    public static function getSemesterAktif()
    {
        return self::where('status', 'Aktif')->first();
    }
}
