<?php

namespace App\Http\Repositories\Consultation;

use App\Models\Prescription;

class PrescriptionRepository
{
    private Prescription $model;

    public function __construct(Prescription $model)
    {
        $this->model = $model;
    }

    public function find($consultationId)
    {
        return $this->model->where('consultation_id', $consultationId)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
