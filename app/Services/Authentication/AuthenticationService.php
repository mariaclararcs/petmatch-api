<?php

namespace App\Services\Authentication;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationService {
     /**
     * Realiza o login do usuário com as credenciais fornecidas.
     *
     * @param  array  $data  Dados de autenticação do usuário.
     * @return array Retorna o token JWT e os dados do usuário autenticado.
     *
     * @throws ApiException Se as credenciais forem inválidas ou ocorrer um erro na autenticação.
     */
    public function login(array $data): array
    {
        if (!Auth::attempt($data)) {
            throw new ApiException('Credenciais inválidas.', 401);
        }

        $user = Auth::user();

        if (! $user instanceof User) {
            throw new ApiException('Erro ao autenticar o usuário.', 500);
        }

        return [
            'token' => JWTAuth::fromUser($user),
            'user' => $user,
        ];
    }

     /**
     * Retorna o usuário autenticado.
     *
     * @return User O usuário autenticado.
     *
     * @throws ApiException Se o usuário não estiver autenticado ou a sessão for inválida.
     */
    public function me(): User
    {
        $user = JWTAuth::user();

        if (! $user instanceof User) {
            throw new ApiException('Usuário não autenticado.', 401);
        }

        return $user;
    }

    /**
     * Realiza o logout do usuário autenticado.
     *
     * Invalida o token JWT e remove a sessão do cache.
     */
    public function logout(): void
    {
        JWTAuth::invalidate();
    }
}