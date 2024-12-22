<?php

namespace App\Http\Repositories\Consultation;

use App\Models\Exam;

class ExamRepository
{
    private Exam $model;

    public function __construct(Exam $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
