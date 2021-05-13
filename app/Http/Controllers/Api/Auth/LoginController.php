<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // 機密情報をユーザー側に置いておかないため
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'eJQhwDHd7VgEj6595axWPjyBLouiyu7VaYR0noQ5',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $requestToken = Request::create(env('APP_URL') . '/oauth/token', 'post');
        $response = Route::dispatch($requestToken);

        return $response;
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->noContent();
    }
}
