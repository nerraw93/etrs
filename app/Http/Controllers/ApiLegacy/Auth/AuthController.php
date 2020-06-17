<?php

namespace App\Http\Controllers\ApiLegacy\Auth;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLegacy\Auth\LoginRequest;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use App\Http\Resources\Legacy\UserResource;

class AuthController extends AccessTokenController
{
    /**
     * Login
     *
     * @param  LoginRequest $request
     * @return response
     */
    public function login(ServerRequestInterface $serverRequest, LoginRequest $request)
    {
        if (auth()->check()) {
            return legacy_errorify(trans('message.auth.login.error.already_login'));
        }

        $issueToken = $this->issueToken($serverRequest);

        if ($issueToken->status() == Response::HTTP_OK) {
            $tokenResult = json_decode($issueToken->getContent(), true);

            $user = User::where('username', $request->username)->first();

            return legacy_successful([
                'oauthToken' => $tokenResult['access_token'],
                'refresh_token' => $tokenResult['refresh_token'],
                'expires_in' => $tokenResult['expires_in'],
                'user' => new UserResource($user),
            ]);
        }

        return legacy_errorify(trans('message.auth.login.error.credentials'));

    }
}
