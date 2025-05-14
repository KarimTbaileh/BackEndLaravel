<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobb extends Model
{
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

    ];


    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'jobb_id');
    }
}
