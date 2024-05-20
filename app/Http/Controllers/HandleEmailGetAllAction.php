<?php

namespace App\Http\Controllers;

use App\Facades\EmailStorage;
use App\Http\Requests\GetAllEmailsRequest;
use Illuminate\Http\JsonResponse;

class HandleEmailGetAllAction extends Controller
{
    public function __invoke(GetAllEmailsRequest $request): JsonResponse
    {
        try {
            $emails = EmailStorage::all(
                $request->input('limit') ?? EmailStorage::DEFAULT_LIMIT,
                $request->input('offset') ?? EmailStorage::DEFAULT_OFFSET,
                $request->input('sortBy') ?? EmailStorage::DEFAULT_SORT_BY,
                $request->input('with') ?? EmailStorage::DEFAULT_WITH_RELATIONS
            );

            return response()->json([
                'message' => 'Successfully retrieved emails.',
                'result' => $emails->toArray(),
                'total' => EmailStorage::getEmailCount(),
            ], 200);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
