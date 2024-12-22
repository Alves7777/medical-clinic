<?php

namespace App\Http\Requests\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'consultation_id' => 'required|exists:consultations,id',
            'medication' => 'required|string|max:255',
            'instructions' => 'required|string',
        ];
    }
}
