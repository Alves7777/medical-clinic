<?php

namespace App\Http\Controllers\V1\Consultation;

use App\Core\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Consultation\ExamRequest;
use App\Http\Services\Consultation\ExamService;
use Exception;
use Illuminate\Http\JsonResponse;

class ExamController extends Controller
{
    private ExamService $examService;
    private ApiResponseService $apiResponseService;

    public function __construct(ApiResponseService $apiResponseService, ExamService $examService)
    {
        $this->examService = $examService;
        $this->apiResponseService = $apiResponseService;
    }

    public function store(ExamRequest $request): JsonResponse
    {
        try {
            $exam = $this->examService->create($request->validated());
            return $this->apiResponseService->success($exam, 'Exame registrado com sucesso', 201);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }
}
