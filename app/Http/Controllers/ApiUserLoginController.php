<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use ValidateRequests;
use Carbon\Carbon;
use App\User;

class ApiUserLoginController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
        {
            return response()
            ->json([
                'status' => '401',
                'message' => 'Unauthenticated',
                ]);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()
        ->json([
            'status' => '200',
            'access_token' => $tokenResult->accessToken,
            ]);
    }
}
