<?php declare(strict_types = 1);

namespace App\Http\Controllers\API;

use JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;

class LoginController extends APIController
{
    public $loginAfterSignUp = true;
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
