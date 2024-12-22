<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'patient_name',
        'patient_age',
        'doctor_id',
        'consultation_date',
        'status',
        'finished_at',
    ];

    protected $casts = [
        'consultation_date' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
