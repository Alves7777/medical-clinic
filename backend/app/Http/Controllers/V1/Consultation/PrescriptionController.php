<?php

namespace App\Http\Controllers\V1\Consultation;

use App\Core\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Consultation\PrescriptionRequest;
use App\Http\Services\Consultation\PrescriptionService;
use Exception;
use Illuminate\Http\JsonResponse;

class PrescriptionController extends Controller
{
    private PrescriptionService $prescriptionService;
    private ApiResponseService $apiResponseService;

    public function __construct(ApiResponseService $apiResponseService, PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
        $this->apiResponseService = $apiResponseService;
    }

    public function index($consultationId): JsonResponse
    {
        try {
            $doctors = $this->prescriptionService->get($consultationId);
            return $this->apiResponseService->success($doctors, 'Prescrição listado com sucesso', 200);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(PrescriptionRequest $request): JsonResponse
    {
        try {
            $prescription = $this->prescriptionService->create($request->validated());
            return $this->apiResponseService->success($prescription, 'Prescription created successfully', 201);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }
}
