<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobb extends Model
{
    use HasFactory;

    protected $fillable = [
        'Requirements',
        'Location',
        'job_type',
        'Currency',
        'Frequency',
        'Salary',
        'Type',
        'Title',
        'Description',
        'Status',
        'publication_status',
        'employer_id', // تعديل من employeer_id إلى employer_id
        'logo',
        'document',
    ];

    protected $casts = [
        'Salary' => 'integer',
        'publication_status' => 'string',
        'Status' => 'string',
    ];

    public function employer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employer::class, 'employer_id'); // تعديل من employeer_id إلى employer_id
    }

    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'jobb_id');
    }
}
