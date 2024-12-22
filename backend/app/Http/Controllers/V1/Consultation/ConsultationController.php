<?php

namespace App\Http\Controllers\V1\Consultation;

use App\Core\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Consultation\CompleteConsultationRequest;
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
            $consultations = $this->consultationService->get($doctorId);
            return $this->apiResponseService->success($consultations, 'Consulta listada com sucesso', 200);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(ConsultationRequest $request): JsonResponse
    {
        try {
            $consultation = $this->consultationService->create($request->validated());
            return $this->apiResponseService->success($consultation, 'Consulta criada com sucesso', 201);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function complete(CompleteConsultationRequest $request): JsonResponse
    {
        try {
            $consultation = $this->consultationService->completeConsultation($request->validated()['consultation_id']);
            return $this->apiResponseService->success($consultation, 'Consulta concluída com sucesso', 200);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function history($doctorId): JsonResponse
    {
        try {
            $history = $this->consultationService->getHistory($doctorId);
            return $this->apiResponseService->success($history, 'Histórico de atendimentos listado com sucesso', 200);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }
}
