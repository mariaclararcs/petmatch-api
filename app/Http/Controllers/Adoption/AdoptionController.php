<?php

namespace App\Http\Controllers\Adoption;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adoption\IndexAdoptionRequest;
use App\Http\Requests\Adoption\ShowAdoptionRequest;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Http\Requests\Adoption\UpdateAdoptionStatusRequest;
use App\Http\Resources\Adoption\AdoptionResource;
use App\Services\Adoption\AdoptionService;
use Illuminate\Http\JsonResponse;

class AdoptionController extends Controller
{
    public function __construct(protected AdoptionService $adoptionService)
    {
    }

    public function index(IndexAdoptionRequest $request): JsonResponse // Usar Request específica
    {
        try {
            return ReturnApi::success(
                AdoptionResource::collection($this->adoptionService->index($request->validated())),
                'Adoções listadas com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    public function store(StoreAdoptionRequest $request): JsonResponse
    {
        try {
            $adoption = $this->adoptionService->store($request->validated());

            return ReturnApi::success(
                new AdoptionResource($adoption),
                'Formulário de adoção enviado com sucesso!',
                201
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    public function updateStatus(string $id, UpdateAdoptionStatusRequest $request): JsonResponse
    {
        try {
            $adoption = $this->adoptionService->updateStatus($id, $request->status);

            return ReturnApi::success(
                new AdoptionResource($adoption),
                'Status da adoção atualizado com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    public function show(ShowAdoptionRequest $request): JsonResponse // Usar Request específica
    {
        try {
            $adoption = $this->adoptionService->show($request->validated());

            return ReturnApi::success(
                new AdoptionResource($adoption),
                'Adoção encontrada com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}