<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function advices()
    {
        return $this->hasMany(Advice::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
