<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'Cv',
        'Applicant Name',
        'Cover Letter',
        'Status',
        'position applied',
        'jobb_id'

    ];

    public function jobb(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Jobb::class, 'jobb_id');
    }
}
