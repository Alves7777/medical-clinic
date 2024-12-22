<?php

namespace App\Http\Services\Consultation;


use App\Http\Repositories\Consultation\ConsultationRepository;
use Carbon\Carbon;
use Exception;

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

    public function completeConsultation(int $consultationId)
    {
        $consultation = $this->consultationRepository->findById($consultationId);

        if (!$consultation) {
            throw new Exception("Consulta não existe.", 404);
        }

        $consultation->status = 'completed';
        $consultation->finished_at = Carbon::now();
        $consultation->consultation_duration = (int) $consultation->finished_at->diffInMinutes($consultation->consultation_date);
        $consultation->save();

        return $consultation;
    }

    public function getHistory($doctorId)
    {
        $consultations = $this->consultationRepository->getHistory($doctorId);

        $consultations->each(function ($consultation) {
            if ($consultation->finished_at) {
                $consultation->consultation_duration = (int) $consultation->finished_at->diffInMinutes($consultation->consultation_date);
            }
        });

        return $consultations;
    }
}
