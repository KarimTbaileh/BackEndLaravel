<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeer extends Model
{ use HasFactory;
    protected $fillable=[

        'name',
        'language',
        'job_title',
    ];

    public function jobbs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Jobb::class);
    }
}
