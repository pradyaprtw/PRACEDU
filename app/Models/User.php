<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Jangan lupa tambahkan 'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke langganan yang dimiliki user.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Relasi ke percobaan ujian yang dilakukan user.
     */
    public function examAttempts()
    {
        return $this->hasMany(UserExamAttempt::class);
    }

    /**
     * Cek apakah user memiliki langganan aktif.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()->where('end_date', '>=', now())->exists();
    }
}
