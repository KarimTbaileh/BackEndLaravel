<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $table = 'employers'; // تعديل الاسم
    protected $fillable = [
        'language',
        'job_title',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobbs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Jobb::class, 'employer_id'); // تعديل employeer_id إلى employer_id
    }
}
