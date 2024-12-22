<?php

namespace App\Http\Services\Consultation;

use App\Http\Repositories\Consultation\PrescriptionRepository;

class PrescriptionService
{
    private PrescriptionRepository $prescriptionRepository;

    public function __construct(PrescriptionRepository $prescriptionRepository)
    {
        $this->prescriptionRepository = $prescriptionRepository;
    }

    public function get($consultationId)
    {
        return $this->prescriptionRepository->find($consultationId);
    }

    public function create(array $data)
    {
        return $this->prescriptionRepository->create($data);
    }
}
