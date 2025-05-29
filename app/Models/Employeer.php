<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static where(string $string, string $string1, string $string2)
 */
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
