<?php

namespace App\Http\Controllers\Adoption;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animal\IndexRequest;
use App\Http\Resources\Adoption\AdoptionResource;
use App\Models\Adoption;
use App\Services\Adoption\AdoptionService;
use Illuminate\Http\JsonResponse;

class AdoptionController extends Controller
{
    public function __construct(protected AdoptionService $adoptionService )
    {
        
    }

    public function index(IndexRequest $request): JsonResponse
    {
        try { 
            return ReturnApi::success(
            $this->adoptionService->index($request->validated()),
            'Adoções listadas com sucesso!'
            );
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
