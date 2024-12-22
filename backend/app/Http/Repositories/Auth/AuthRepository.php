<?php

namespace App\Http\Repositories\Auth;

use App\Models\Doctor;

class AuthRepository
{
    private Doctor $model;

    public function __construct(Doctor $model)
    {
        $this->model = $model;
    }

    public function createDoctor(array $data): Doctor
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function findDoctorByEmail(string $email): ?Doctor
    {
        return $this->model->where('email', $email)->first();
    }
}
