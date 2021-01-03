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

class ApiUserRegisterController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }


    public function test()
    {
        return 200;
    }

    public function register(Request $request)
    {

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials))
        {
            return response()
            ->json([
                'status' => '403',
                'message' => 'User Already Exist',
                ]);
        }

        $user = User::create([
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            ]);

        // $user->sendEmailVerificationNotification();

        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => '*'
        ];

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
