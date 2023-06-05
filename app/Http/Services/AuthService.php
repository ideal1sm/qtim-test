<?php

namespace App\Http\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @throws Exception
     */
    public function login(array $credentials): array
    {
        if (!$token = auth('api')->attempt($credentials)) {
            throw new Exception('Неправильный логин или пароль', 403);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @throws Exception
     */
    public function register(array $credentials): array
    {
        $credentialsForLogin = [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ];

        $credentials['password'] = Hash::make($credentials['password']);

        if (!User::create($credentials))
            throw new Exception('Ошибка при сохранении', 500);

        return $this->login($credentialsForLogin);
    }

    public function logout(): array
    {
        auth('api')->logout();

        return [
            'message' => 'Успешно'
        ];
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'type' => 'Bearer',
            'expires_in' => Config::get('jwt.ttl') * 60,

        ];
    }
}
