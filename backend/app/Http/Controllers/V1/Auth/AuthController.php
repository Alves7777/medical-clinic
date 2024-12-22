<?php

namespace App\Http\Controllers\V1\Auth;

use App\Core\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private ApiResponseService $apiResponseService;
    private AuthService $authService;

    public function __construct(ApiResponseService $apiResponseService, AuthService $authService)
    {
        $this->apiResponseService = $apiResponseService;
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->register($request->validated());
            return $this->apiResponseService->success($data, 'User registered successfully');
        } catch (\Exception $e) {
            return $this->apiResponseService->fail($e->getMessage(), $e->getCode());
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->login($request->validated());

            if (!$data['success']) {
                return $this->apiResponseService->fail($data['message'], 401);
            }

            return $this->apiResponseService->success($data, 'Logged in successfully');
        } catch (\Exception $e) {
            return $this->apiResponseService->fail($e->getMessage(), $e->getCode());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());
            return $this->apiResponseService->success([], 'Logged out successfully');
        } catch (\Exception $e) {
            return $this->apiResponseService->fail($e->getMessage(), $e->getCode());
        }
    }

    public function me(Request $request): JsonResponse
    {
        try {
            $data = $this->authService->me($request->user());
            return $this->apiResponseService->success($data, 'User data retrieved successfully');
        } catch (\Exception $e) {
            return $this->apiResponseService->fail($e->getMessage(), $e->getCode());
        }
    }
}