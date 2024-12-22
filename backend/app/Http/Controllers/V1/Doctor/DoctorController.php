<?php

namespace App\Http\Controllers\V1\Doctor;

use App\Core\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Services\Doctor\DoctorService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class DoctorController extends Controller
{
    private DoctorService $doctorService;
    private ApiResponseService $apiResponseService;

    public function __construct(ApiResponseService $apiResponseService, DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
        $this->apiResponseService = $apiResponseService;
    }

    public function index(): JsonResponse
    {
        try {
            $doctors = $this->doctorService->get();
            return $this->apiResponseService->success($doctors, 'Médicos listados com sucesso', 200);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreDoctorRequest $request): JsonResponse
    {
        try {
            $doctor = $this->doctorService->create($request->validated());
            return $this->apiResponseService->success($doctor, 'Doutor criado com sucesso', 201);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $doctor = $this->doctorService->show($id);
            return $this->apiResponseService->success($doctor, 'Médico recuperado com sucesso', 200);
        } catch (ModelNotFoundException $e) {
            return $this->apiResponseService->fail('Médico não encontrado', 404);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function update(UpdateDoctorRequest $request, int $id): JsonResponse
    {
        try {
            $doctor = $this->doctorService->update($id, $request->validated());
            return $this->apiResponseService->success($doctor, 'Doutor atualizado com sucesso', 200);
        } catch (ModelNotFoundException $e) {
            return $this->apiResponseService->fail('Médico não encontrado', 404);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->doctorService->delete($id);
            return $this->apiResponseService->success(null, 'Doutor excluído com sucesso', 204);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), $e->getCode());
        }
    }
}

