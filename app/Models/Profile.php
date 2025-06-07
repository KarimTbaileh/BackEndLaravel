<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'Skill',
        'Cv',
        'Summary',
        'Email',
        'Experience',
        'Education',
        'Country',
        'City',
        'phone_number',
        'FirstName',
        'LastName',
        'user_id',
    ];

    protected $table = 'profiles';

    protected $casts = [
        'phone_number' => 'string',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
