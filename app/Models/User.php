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
        if (!$this->isMahasiswa()) {
            return 0;
        }

        $mahasiswa = $this->mahasiswa;
        if (!$mahasiswa) {
            return 0;
        }

        $totalDosen = Dosen::count();
        if ($totalDosen === 0) {
            return 0;
        }

        $sudahVoting = Voting::where('mahasiswa_id', $mahasiswa->id)->count();
        return round(($sudahVoting / $totalDosen) * 100);
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
