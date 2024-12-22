<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:doctors,email,' . $this->route('doctor'),
            'password' => 'nullable|min:8',
        ];
    }
}
