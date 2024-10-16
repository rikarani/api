<?php

namespace Tests\Feature;

use App\Facades\Codashop;
use Illuminate\Testing\Fluent\AssertableJson;

describe('API Response', function () {
    it('should ok and have exact shape of response', function () {
        Codashop::shouldReceive('genshin')->once()->andReturn([
            "errorCode" => "",
            'confirmationFields' => [
                'productName' => 'Genshin Impact',
                'username' => 'J******m',
            ],
            'user' => [
                'userId' => '812345678',
                "zoneId" => "os_asia"
            ],
        ]);

        /**
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson('/cek-ign/genshin?uid=812345678');

        $response->assertStatus(200)->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                'success',
                'code',
                'data.game',
                'data.account.ign',
                'data.account.uid',
                'data.account.server',
            ]);
        });
    });

    it('should 404 and have exact shape of response', function () {
        Codashop::shouldReceive('genshin')->once()->andReturn([
            "errorCode" => "-100",
        ]);

        /**
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson('/cek-ign/genshin?uid=958694039');

        $response->assertStatus(404)->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                'success',
                'code',
                'error.name',
                'error.message',
            ]);
        });
    });
});

describe('Validation', function () {
    test('missing uid from query', function () {
        /**
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson('/cek-ign/genshin');

        $response->assertStatus(400)->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'code'])->has('errors', 1, function (AssertableJson $json) {
                $json->where('path', 'uid')->where('message', 'The uid field is required.');
            });
        });
    });

    test("invalid uid", function () {
        /**
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson('/cek-ign/genshin?uid=123456789');

        $response->assertStatus(400)->assertJson(function (AssertableJson $json) {
            $json->hasAll(["success", "code"])->has("errors", 1, function (AssertableJson $json) {
                $json->where("path", "uid")->where("message", "Invalid UID");
            });
        });
    });
});
