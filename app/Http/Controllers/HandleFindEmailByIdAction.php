<?php

namespace App\Http\Controllers;

use App\Facades\EmailStorage;
use App\Http\Requests\FindEmailByIdRequest;
use Illuminate\Http\JsonResponse;

class HandleFindEmailByIdAction extends Controller
{
    public function __invoke(FindEmailByIdRequest $request): JsonResponse
    {
        try {
            $withRelations = $request->has('with_relations')
                ? $request->get('with_relations')
                : EmailStorage::DEFAULT_WITH_RELATIONS;

            if ($email = EmailStorage::find($request->input('id'), $withRelations)) {
                return response()->json([
                    'message' => 'Successfully retrieved the email.',
                    'result' => $email->toArray(),
                ]);
            }

            return response()->json([
                'message' => 'Unable to locate any emails by that ID.',
            ], 404);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
