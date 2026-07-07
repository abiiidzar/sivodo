<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aktivitas',
        'deskripsi',
    ];

    // Relasi N:1 dengan User (inverse)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Static method untuk mencatat aktivitas
    public static function logActivity($userId, $aktivitas, $deskripsi)
    {
        return self::create([
            'user_id' => $userId,
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
        ]);
    }
}
