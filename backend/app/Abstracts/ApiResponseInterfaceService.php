<?php

namespace App\Abstracts;

interface ApiResponseInterfaceService
{
    public function success($data = null, $message = null, $code = 200);

    public function fail($message = null, $code = 400);

    public function error($data = null, $message = null, $code = 500);

}
