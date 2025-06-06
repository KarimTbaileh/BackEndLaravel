<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = [
        'name',
        'birthdate',
        'email',
        'phone',
        'address',
        'education',
        'experience',
    ];

    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'job_seeker_id');
=======
    protected $table = 'job_seeker';
    protected $fillable = [
        'country',
        'gender',
        'day',
        'month',
        'year',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
>>>>>>> wasseemQ
    }
}
