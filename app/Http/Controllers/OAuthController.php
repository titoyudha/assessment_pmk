<?php

namespace App\Http\Controllers;

use App\Helpers\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class OAuthController extends Controller
{
    // Implements Simple Oauth
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $this->createAccessToken($user, $request);

            return apiResponse::success(['access_token' => $token], 'Login Success');
        } else {
            return apiResponse::error('Invalid credentials', 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return apiResponse::success(null, 'Logout Success');
    }

    private function createAccessToken($user, Request $request)
    {
        $tokenRequest = $request->create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'username' => $user->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        $response = Route::dispatch($tokenRequest);

        return json_decode($response->getContent(), true)['access_token'];
    }

    private function getClientId()
    {
        return $this->getClient()->id;
    }

    private function getClientSecret()
    {
        return $this->getClient()->secret;
    }

    private function getClient()
    {
        return Client::where('password_client', true)->first();
    }


}
