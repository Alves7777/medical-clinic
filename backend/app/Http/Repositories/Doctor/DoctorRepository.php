<?php

namespace App\Http\Repositories\Doctor;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection;

class DoctorRepository
{
    private Doctor $model;

    public function __construct(Doctor $model)
    {
        $this->model = $model;
    }

    public function get(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Doctor
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?Doctor
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): Doctor
    {
        $doctor = $this->findById($id);
        $doctor->update($data);
        return $doctor;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }
}
