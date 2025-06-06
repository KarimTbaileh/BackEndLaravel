<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static create(array $array)
 * @method static where(string $string, $jobbId)
 */
class Application extends Model
{ use HasFactory;
    protected $fillable = [
        'Cv',
        'Cover Letter',
        'Status',
        'position applied',
        'jobb_id',
        'job_seeker_id'

    ];



    public function jobb(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Jobb::class, 'jobb_id');
    }

    public function jobSeeker(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id');
    }
}
