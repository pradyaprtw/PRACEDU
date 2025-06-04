<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser; 
use Filament\Panel; 
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable implements FilamentUser // Implementasikan FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahkan role
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // 'role' => RoleEnum::class, // Kita akan gunakan accessor/mutator sederhana dulu
    ];

    /**
     * Mendefinisikan accessor dan mutator untuk atribut 'role'.
     * Ini memastikan bahwa nilai 'role' selalu valid.
     */
    protected function role(): Attribute
    {
        return new Attribute(
            get: fn ($value) => in_array($value, ['student', 'admin', 'mentor']) ? $value : 'student', // Default ke 'student' jika tidak valid
            set: fn ($value) => in_array($value, ['student', 'admin', 'mentor']) ? $value : 'student'
        );
    }

    /**
     * Implementasi metode canAccessPanel dari FilamentUser.
     * Hanya user dengan role 'admin' atau 'mentor' yang bisa mengakses panel admin.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'mentor']);
    }

    public function orders(): HasMany // Tambahkan ini
    {
        return $this->hasMany(Order::class);
    }

    public function enrollments(): HasMany // Tambahkan ini
    {
        return $this->hasMany(Enrollment::class);
    }

    public function forumThreads(): HasMany // Tambahkan ini
    {
        return $this->hasMany(ForumThread::class, 'user_id');
    }

    public function forumPosts(): HasMany // Tambahkan ini
    {
        return $this->hasMany(ForumPost::class, 'user_id');
    }

    public function userSchedules(): HasMany // Tambahkan ini
    {
        return $this->hasMany(UserSchedule::class);
    }

    public function userQuizAttempts(): HasMany // Tambahkan ini
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function userSimulationAttempts(): HasMany // Tambahkan ini
    {
        return $this->hasMany(UserSimulationAttempt::class);
    }
}