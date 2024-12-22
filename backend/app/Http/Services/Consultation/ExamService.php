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

    public function create(array $data)
    {
        return $this->examRepository->create($data);
    }
}
