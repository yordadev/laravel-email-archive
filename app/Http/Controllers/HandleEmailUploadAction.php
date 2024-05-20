<?php

namespace App\Http\Controllers;

use App\Facades\EmailStorage;
use App\Http\Requests\UploadEmailRequest;
use Illuminate\Http\JsonResponse;

class HandleEmailUploadAction extends Controller
{
    public function __invoke(UploadEmailRequest $request): JsonResponse
    {
        try {
            $email = EmailStorage::store($request->file('file'));

            return response()->json([
                'message' => 'Email was successfully uploaded',
                'result' => $email->toArray(),
            ], 201);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
