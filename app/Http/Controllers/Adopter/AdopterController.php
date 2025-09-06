<?php

namespace App\Http\Controllers\Adopter;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adopter\IdAdopterRequest;
use App\Http\Requests\Adopter\IndexAdopterRequest;
use App\Http\Requests\Adopter\StoreAdopterRequest;
use App\Http\Requests\Adopter\UpdateAdopterRequest;
use App\Services\Adopter\AdopterService;

class AdopterController extends Controller
{
    public function __construct(protected AdopterService $service){}

    public function store(StoreAdopterRequest $request){
        try{
            $data = $this->service->store($request->validated());
            return ReturnApi::success($data, 'Adotante criado com sucesso.', 200);
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function index(IndexAdopterRequest $request){
        try{
            $data = $this->service->index($request->validated());
            return ReturnApi::success($data, 'Adotantes listados com sucesso.', 200);
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function show(IdAdopterRequest $request){
        try{
            $data = $this->service->show($request->validated());
            return ReturnApi::success($data, 'Adotante exibido com sucesso.', 200);
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function update(UpdateAdopterRequest $request){
        try{
            $data = $this->service->update($request->validated());
            return ReturnApi::success($data, 'Adotante atualizado com sucesso.', 200);
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }

    public function destroy(IdAdopterRequest $request){
        try{
            $data = $this->service->delete($request->validated());
            return ReturnApi::success($data, 'Adotante excluído com sucesso.', 200);
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage(), 400);
        }
    }
}
