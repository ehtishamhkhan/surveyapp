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
use App\FormResponse;

class ResponseController extends Controller
{
    public function save(Request $request)
    {
        FormResponse::updateOrCreate(
            [
                'form_id' => $request['form_id'],
                'respondent_id' => $request->user()->id,
            ],
            [
                'response_csv' => $request['response_csv'],
            ]

        );


        return response()
            ->json([
                'status' => '200',
                'message' => 'Response saved',
            ]);
    }
}
