<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $table = 'employeer';
    protected $fillable = [
        'language',
        'job_title',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobbs()
    {
        return $this->hasMany(Jobb::class, 'employeer_id');
    }
}
