<?php

namespace App\Http\Services\Consultation;

use App\Http\Repositories\Consultation\ExamRepository;

class ExamService
{
    private ExamRepository $examRepository;

    public function __construct(ExamRepository $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    public function get($consultationId)
    {
        return $this->examRepository->find($consultationId);
    }

    public function create(array $data)
    {
        return $this->examRepository->create($data);
    }
}
