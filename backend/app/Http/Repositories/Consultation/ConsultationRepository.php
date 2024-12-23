<?php

namespace App\Http\Repositories\Consultation;

use App\Models\Consultation;

class ConsultationRepository
{
    private Consultation $model;

    public function __construct(Consultation $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($doctorId)
    {
        return $this->model->where('doctor_id', $doctorId)->get();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function getHistory($doctorId)
    {
        return $this->model->where('doctor_id', $doctorId)
            ->with('exams')
            ->get();
    }
}
