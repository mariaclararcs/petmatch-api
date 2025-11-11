<?php

namespace App\Http\Controllers\Adoption;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Http\Requests\Adoption\UpdateAdoptionStatusRequest;
use App\Http\Resources\Adoption\AdoptionResource;
use App\Models\Adoption;
use App\Services\Adoption\AdoptionService;
use Illuminate\Http\JsonResponse;

class AdoptionController extends Controller
{
    public function __construct(protected AdoptionService $adoptionService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $data = request()->validate([
                'search' => 'sometimes|string',
                'page' => 'sometimes|integer',
                'per_page' => 'sometimes|integer'
            ]);

            return ReturnApi::success(
                AdoptionResource::collection($this->adoptionService->index($data)),
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

    public function show(string $id): JsonResponse
    {
        try {
            $adoption = Adoption::with(['adopter', 'animal', 'ong'])
                ->findOrFail($id);

            return ReturnApi::success(
                new AdoptionResource($adoption),
                'Adoção encontrada com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}