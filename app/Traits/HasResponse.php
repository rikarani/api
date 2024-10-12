<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Http\Response as Code;
use Illuminate\Support\Facades\Response;

trait HasResponse
{
    public function ok(Collection $data)
    {
        return Response::json([
            'success' => true,
            'code' => Code::HTTP_OK,
            'data' => $data,
        ], Code::HTTP_OK);
    }

    public function badRequest(Collection $errors)
    {
        return Response::json([
            'success' => false,
            'code' => Code::HTTP_BAD_REQUEST,
            'errors' => $errors,
        ], Code::HTTP_BAD_REQUEST);
    }

    public function notFound()
    {
        return Response::json([
            'success' => false,
            'code' => Code::HTTP_NOT_FOUND,
            'error' => [
                'name' => 'Not Found',
                'message' => 'IGN Tidak Ditemukan',
            ],
        ], Code::HTTP_NOT_FOUND);
    }
}
