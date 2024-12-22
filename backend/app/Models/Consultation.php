<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_age',
        'doctor_id',
        'consultation_date',
        'status',
        'finished_at',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
