<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobb extends Model
{  use HasFactory;
    protected $fillable = [
        'Requirements',
        'Location',
        'Job Type',
        'Currency',
        'Frequency',
        'Salary',
        'Type',
        'Title',
        'Description',
        'Status',
        'employeer_id',

    ];
    public function employeer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employeer::class);
    }


    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'jobb_id');
    }
}
