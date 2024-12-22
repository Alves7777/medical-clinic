<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data): array
    {
        $doctor = $this->authRepository->createDoctor($data);
        $token = $doctor->createToken('auth_token')->plainTextToken;

        return [
            'data' => $doctor,
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function login(array $credentials): array
    {
        $doctor = $this->authRepository->findDoctorByEmail($credentials['email']);

        if (!$doctor || !Hash::check($credentials['password'], $doctor->password)) {
            return [
                'success' => false,
                'message' => 'Credenciais inválidas',
            ];
        }

        $token = $doctor->createToken('auth_token')->plainTextToken;

        return [
            'success' => true,
            'data' => $doctor,
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function logout($doctor): void
    {
        if ($doctor && $doctor->currentAccessToken()) {
            $doctor->currentAccessToken()->delete();
        } else {
            throw new \Exception('Usuário não autenticado ou token inválido', 401);
        }
    }

    public function me($doctor): array
    {
        return ['data' => $doctor];
    }
}
