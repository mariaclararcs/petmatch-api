<?php

namespace App\Http\Controllers\Ong;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ong\IndexRequest;
use App\Http\Requests\Ong\StoreRequest;
use App\Http\Requests\Ong\UpdateRequest;
use App\Http\Resources\Ong\OngResource;
use App\Models\Ong;
use App\Services\Ong\OngService;
use Illuminate\Http\JsonResponse;

class OngController extends Controller
{

    public function __construct(public OngService $service) {}


    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): JsonResponse
    {
        try {

            return ReturnApi::success(
            OngResource::collection(Ong::all()),
            'Ong successfully listed!'
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
            'Ong successfully created!',
            201
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ong $ong): JsonResponse
    {
        try {
            return ReturnApi::success(
                OngResource::make($ong),
                'Ong successfully consulted!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request,Ong $ong): JsonResponse
    {
        try {
            return ReturnApi::success(
                $ong->update($request->validated()),
                'Ong successfully updated!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
    * Destroy the specified resource in storage.
    */
    public function destroy(Ong $ong): JsonResponse
    {

        try {
            $ong->delete();

            return ReturnApi::success(
                message: 'Ong successfully deleted!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}