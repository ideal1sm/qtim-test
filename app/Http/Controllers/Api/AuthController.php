<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $service;
    public function __construct(AuthService $service)
    {
        $this->middleware('auth:api')->except(['login', 'register']);
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        try {
            return response()->json($this->service->login($request->validated()));
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            return response()->json($this->service->register($request->validated()));
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function user()
    {
        return new UserResource(auth('api')->user());
    }

    public function logout()
    {
        return response()->json(
            $this->service->logout()
        );
    }

    public function refresh()
    {
        return response()->json(
            $this->service->refresh()
        );
    }
}
