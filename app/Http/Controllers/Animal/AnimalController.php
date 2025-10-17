<?php

namespace App\Http\Controllers\Animal;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animal\DestroyRequest;
use App\Http\Requests\Animal\IndexRequest;
use App\Http\Requests\Animal\MyAnimalRequest;
use App\Http\Requests\Animal\ShowRequest;
use App\Http\Requests\Animal\StoreRequest;
use App\Http\Requests\Animal\UpdateRequest;
use App\Http\Resources\Animal\AnimalResource;
use App\Models\Animal;
use App\Services\Animal\AnimalService;
use Illuminate\Http\JsonResponse;

class AnimalController extends Controller
{

    public function __construct(public AnimalService $service) {}


    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): JsonResponse
    {
        try {

            return ReturnApi::success(
                $this->service->index($request->validated()),
                'Animais listados com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            return ReturnApi::success(
                $this->service->store(
                    $request->validated(),
                ),
                'Animal criado com sucesso!',
                201
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowRequest $request): JsonResponse
    {
        try {
            return ReturnApi::success(
                $this->service->show($request->validated()),
                'Animal exibido com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            return ReturnApi::success(
                $this->service->update($request->validated()),
                'Animal atualizado com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Destroy the specified resource in storage.
     */
    public function destroy(DestroyRequest $request): JsonResponse
    {

        try {
            return ReturnApi::success(
                $this->service->destroy($request->validated()),
                message: 'Animal deletado com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    public function myAnimals(MyAnimalRequest $request){
        try{
            $data = $this->service->myAnimals($request->validated());
            return ReturnApi::success($data, 'Animais listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), $ex->getCode());
        }
    }
}
