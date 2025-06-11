<?php

namespace Tests\Feature;

use App\Models\Ong;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

describe('Ong routes', function () {
    it('[GET] ongs', function () {
        Ong::factory()->create();

        $response = get('/api/ongs')
            ->assertOk()
            ->json();

            expect($response['data']['data'])->toHaveCount(1);
    });

    it('[GET] ongs/{id}', function () {
        $ong = Ong::factory()->create();

        $response = get("api/ongs/$ong->id")
            ->assertOk()
            ->json();

            expect($response['data']['id'])->toBeString()->toBeUuid();
    });

    it('[POST] Ong', function () {
        $body = Ong::factory()->make()->toArray();

        post('api/ongs', $body)
            ->assertCreated()
            ->json();

            $ongOnDatabase = Ong::query()->first();

            expect($ongOnDatabase->id)->toBeString()->toBeUuid();
    });

    it('[DELETE] ongs/{id}', function () {
        $ong = Ong::factory()->create();

        delete("api/ongs/$ong->id")
            ->assertOk()
            ->json();

            $ongOnDatabase = Ong::query()->find($ong->id);

            expect($ongOnDatabase)->toBeNull();
    });

    it('[PUT] ongs/{id}', function () {
        $ong = Ong::factory()->create();
        $body = Ong::factory()->make()->toArray();

        put("api/ongs/$ong->id",
            $body)
            ->assertOk()
            ->json();
    });
});