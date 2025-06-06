<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD
=======
use Laravel\Sanctum\HasApiTokens;
>>>>>>> wasseemQ

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
<<<<<<< HEAD
    use HasFactory, Notifiable;
=======
    use HasFactory, Notifiable, HasApiTokens;
>>>>>>> wasseemQ

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
<<<<<<< HEAD
=======
        'role',
>>>>>>> wasseemQ
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
<<<<<<< HEAD
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
=======
            //'email_verified_at' => 'datetime',
            //'password' => 'hashed',
        ];
    }
    public function jobSeeker()
    {
        return $this->hasOne(JobSeeker::class);
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

}

>>>>>>> wasseemQ
