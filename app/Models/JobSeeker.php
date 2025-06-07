<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

    // تغيير اسم الجدول ليتوافق مع ملف الهجرة create__applications.php
    protected $table = 'job_seekers';
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
    }

    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'job_seeker_id');
    }
}
