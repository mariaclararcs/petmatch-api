<?php

namespace App\Http\Controllers\Authentication;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Services\Authentication\AuthenticationService;

class AuthenticationController extends Controller
{
     /**
     * Construtor da classe AuthenticationController.
     *
     * @param AuthenticationService $authenticationService Serviço de autenticação injetado.
     */
    public function __construct(protected AuthenticationService $authenticationService){}

    /**
     * Realiza o login do usuário.
     *
     * @param LoginRequest $request Requisição contendo os dados de login validados.
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com os dados de autenticação e uma mensagem de sucesso.
     * @throws ApiException Lança uma exceção em caso de erro na autenticação.
     */
    public function login(LoginRequest $request)
    {
        try{
            $data = $this->authenticationService->login($request->validated());
            return ReturnApi::success($data, 'Autenticação realizada com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }
}
