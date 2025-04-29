<?php

namespace App\Http\Controllers\Animal;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animal\IdAnimalRequest;
use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Http\Requests\IndexRequest;
use App\Services\Animal\AnimalService;

class AnimalController extends Controller
{
    public function __construct(protected AnimalService $animalService){}

    public function store(StoreAnimalRequest $request){
        try{
            $data = $this->animalService->store($request->validated());
            return ReturnApi::success($data, 'Animal criado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function index(IndexRequest $request){
        try{
            $data = $this->animalService->index($request->validated());
            return ReturnApi::success($data, 'Animais listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function show(IdAnimalRequest $request){
        try{
            $data = $this->animalService->show($request->validated());
            return ReturnApi::success($data, 'Animal exibido com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function update(UpdateAnimalRequest $request){
        try{
            $data = $this->animalService->update($request->validated());
            return ReturnApi::success($data, 'Animal atualizado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function destroy(IdAnimalRequest $request){
        try{
            $data = $this->animalService->destroy($request->validated());
            return ReturnApi::success($data, 'Animal deletado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function restore(IdAnimalRequest $request){
        try{
            $data = $this->animalService->restore($request->validated());
            return ReturnApi::success($data, 'Animal restaurado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }
}
