<?php

namespace App\Http\Services\Consultation;


use App\Http\Repositories\Consultation\ConsultationRepository;

class ConsultationService
{
    private ConsultationRepository $consultationRepository;

    public function __construct(ConsultationRepository $consultationRepository)
    {
        $this->consultationRepository = $consultationRepository;
    }

    public function create(array $data)
    {
        return $this->consultationRepository->create($data);
    }

    public function get($doctorId)
    {
        return $this->consultationRepository->find($doctorId);
    }
}
