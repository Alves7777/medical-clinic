<?php

namespace App\Http\Requests\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'patient_name' => 'required|string|max:255',
            'patient_age' => 'required|integer|min:0',
            'doctor_id' => 'required|exists:doctors,id',
            'consultation_date' => 'required|date|after:now',
        ];
    }
}
