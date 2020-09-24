<?php declare(strict_types = 1);

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class APIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function notFound($res = ['status' => 'notfound']): JsonResponse
    {
        return response()->json($res, 404);
    }

    protected function success($res = ['status' => 'success']): JsonResponse
    {
        return response()->json($res);
    }

    protected function error($res = ['status' => 'error'], $code = 500): JsonResponse
    {
        return response()->json($res, $code);
    }

    protected function unauthorized($res = ['status' => 'unauthorized']): JsonResponse
    {
        return response()->json($res, 403);
    }
}
