<?php

namespace App\Http\Controllers\V1\Consultation;

use App\Core\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Consultation\ConsultationRequest;
use App\Http\Services\Consultation\ConsultationService;
use Exception;
use Illuminate\Http\JsonResponse;

class ConsultationController extends Controller
{
    private ConsultationService $consultationService;
    private ApiResponseService $apiResponseService;


    public function __construct(ApiResponseService $apiResponseService, ConsultationService $consultationService)
    {
        $this->consultationService = $consultationService;
        $this->apiResponseService = $apiResponseService;
    }

    public function index($doctorId): JsonResponse
    {
        try {
            $doctors = $this->consultationService->get($doctorId);
            return $this->apiResponseService->success($doctors, 'Consultation listed successfully', 200);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(ConsultationRequest $request): JsonResponse
    {
        try {
            $doctor = $this->consultationService->create($request->validated());
            return $this->apiResponseService->success($doctor, 'Consultation created successfully', 201);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }
}
