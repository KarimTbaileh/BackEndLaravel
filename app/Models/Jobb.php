<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static whereHas(string $string, \Closure $param)
<<<<<<< HEAD
 * @method static where(string $string, $employeerId)
=======
 * @method static where(string $string, $employerId)
>>>>>>> wasseemQ
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
<<<<<<< HEAD
    public function employeer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employeer::class);
=======
    public function employer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employer::class);
>>>>>>> wasseemQ
    }


    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'jobb_id');
    }
}
