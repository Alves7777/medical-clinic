<?php

namespace App\Http\Requests\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class CompleteConsultationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'consultation_id' => 'required|exists:consultations,id',
        ];
    }
}

