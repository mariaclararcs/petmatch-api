<?php

namespace Tests\Feature;

use App\Models\Animal;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

describe('Animal routes', function () {
    it('[GET] animals', function () {
        Animal::factory()->create();

        $response = get('/api/animals')
            ->assertOk()
            ->json();

            expect($response['data']['data'])->toHaveCount(1);
    });

    it('[GET] animals/{id}', function () {
        $animal = Animal::factory()->create();

        $response = get("api/animals/$animal->id")
            ->assertOk()
            ->json();

            expect($response['data']['id'])->toBeString()->toBeUuid();
    });

    it('[POST] Animal', function () {
        $body = Animal::factory()->make()->toArray();

        post('api/animals', $body)
            ->assertCreated()
            ->json();

            $animalOnDatabase = Animal::query()->first();

            expect($animalOnDatabase->id)->toBeString()->toBeUuid();
    });

    it('[DELETE] animals/{id}', function () {
        $animal = Animal::factory()->create();

        delete("api/animals/$animal->id")
            ->assertOk()
            ->json();

            $animalOnDatabase = Animal::query()->find($animal->id);

            expect($animalOnDatabase)->toBeNull();
    });

    it('[PUT] animals/{id}', function () {
        $animal = Animal::factory()->create();
        $body = Animal::factory()->make()->toArray();

        put("api/animals/$animal->id",
            $body)
            ->assertOk()
            ->json();
    });
});