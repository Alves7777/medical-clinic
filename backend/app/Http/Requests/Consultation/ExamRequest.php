<?php

namespace App\Http\Requests\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'consultation_id' => 'required|exists:consultations,id',
            'exam_name' => 'required|string|max:255',
            'exam_date' => 'nullable|date|before_or_equal:today',
        ];
    }
}
