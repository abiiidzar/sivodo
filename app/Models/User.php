<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'foto',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi 1:1 dengan Mahasiswa
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }
    public function getVotingProgress()
    {
        if (!$this->isMahasiswa() || !$this->mahasiswa) {
            return 0;
        }

        // Ambil semester aktif
        $semesterAktif = Semester::where('status', 'Aktif')->first();
        if (!$semesterAktif) {
            return 0;
        }

        // Hitung total mata kuliah yang tersedia untuk kelas mahasiswa ini di semester aktif
        $totalMataKuliah = MataKuliah::where('kelas', $this->mahasiswa->kelas)
                            ->where('semester', $semesterAktif->semester) // Sesuaikan jika pakai semester_id
                            ->count();

        if ($totalMataKuliah === 0) {
            return 0;
        }

        // Hitung berapa yang sudah divoting
        $sudahVoting = Voting::where('mahasiswa_id', $this->mahasiswa->id)
                            ->where('semester_id', $semesterAktif->id)
                            ->count();

        return round(($sudahVoting / $totalMataKuliah) * 100);
    }

    // Relasi 1:N dengan ActivityLog
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPimpinan()
    {
        return $this->role === 'pimpinan';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
}
