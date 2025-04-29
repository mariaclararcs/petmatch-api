<?php

namespace App\Http\Controllers\User;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\User\IdUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    /**
     * Armazena um novo usuário.
     *
     * @param \App\Http\Requests\User\StoreUserRequest $request Requisição contendo os dados validados do usuário.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com os dados do usuário criado e mensagem de sucesso.
     * @throws \App\Exceptions\ApiException Lança uma exceção se ocorrer um erro durante a criação do usuário.
     */
    public function store(StoreUserRequest $request)
    {
        try{
            $data = $this->userService->store($request->validated());
            return ReturnApi::success($data, 'Usuário criado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    /**
     * Lista todos os usuários.
     *
     * @param IndexRequest $request Requisição contendo os parâmetros de validação.
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com a lista de usuários e uma mensagem de sucesso.
     * @throws ApiException Lança uma exceção em caso de erro na listagem dos usuários.
     */
    public function index(IndexRequest $request)
    {
        try{
            $data = $this->userService->index($request->validated());
            return ReturnApi::success($data, 'Usuários listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    /**
     * Exibe os detalhes de um usuário.
     *
     * @param \App\Http\Requests\User\IdUserRequest $request Requisição contendo o ID do usuário.
     * @return \Illuminate\Http\JsonResponse Resposta JSON contendo os dados do usuário e uma mensagem de sucesso.
     * @throws ApiException Se ocorrer um erro ao listar o usuário.
     */
    public function show(IdUserRequest $request)
    {
        try{
            $data = $this->userService->show($request->validated());
            return ReturnApi::success($data, 'Usuário listado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    /**
     * Atualiza as informações de um usuário.
     *
     * @param \App\Http\Requests\User\UpdateUserRequest $request Requisição contendo os dados validados para atualização do usuário.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com os dados atualizados do usuário e mensagem de sucesso.
     * @throws \App\Exceptions\ApiException Lança uma exceção em caso de erro na atualização do usuário.
     */
    public function update(UpdateUserRequest $request)
    {
        try{
            $data = $this->userService->update($request->validated());
            return ReturnApi::success($data, 'Usuário atualizado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    /**
     * Remove o usuário especificado.
     *
     * @param \App\Http\Requests\User\IdUserRequest $request Requisição contendo o ID do usuário a ser deletado.
     * @return \Illuminate\Http\JsonResponse Resposta JSON indicando sucesso ou falha da operação.
     * @throws ApiException Se ocorrer um erro durante a exclusão do usuário.
     */
    public function destroy(IdUserRequest $request)
    {
        try{
            $data = $this->userService->destroy($request->validated());
            return ReturnApi::success($data, 'Usuário deletado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    /**
     * Restaura um usuário a partir de uma solicitação de ID de usuário.
     *
     * @param \App\Http\Requests\User\IdUserRequest $request Solicitação contendo o ID do usuário a ser restaurado.
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com os dados do usuário restaurado e uma mensagem de sucesso.
     * @throws ApiException Lança uma exceção de API com uma mensagem de erro e código de status 400 em caso de falha.
     */
    public function restore(IdUserRequest $request)
    {
        try{
            $data = $this->userService->restore($request->validated());
            return ReturnApi::success($data, 'Usuário restaurado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }
}
