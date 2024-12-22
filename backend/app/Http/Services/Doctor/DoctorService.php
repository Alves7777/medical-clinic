<?php

namespace App\Http\Services\Doctor;

use App\Http\Repositories\Doctor\DoctorRepository;
use App\Models\Doctor;

class DoctorService
{
    private DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function get()
    {
        return $this->doctorRepository->get();
    }

    public function create(array $data): Doctor
    {
        $data['password'] = bcrypt($data['password']);
        return $this->doctorRepository->create($data);
    }

    public function show(int $id): ?Doctor
    {
        return $this->doctorRepository->findById($id);
    }

    public function update(int $id, array $data): Doctor
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return $this->doctorRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->doctorRepository->delete($id);
    }
}
