<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static whereHas(string $string, \Closure $param)
 * @method static where(string $string, $employerId)
 */
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
        'publication_status',
        'employeer_id',

    ];
    public function employer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }


    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'jobb_id');
    }
}
