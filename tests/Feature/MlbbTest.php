<?php

namespace Tests\Feature;

use App\Facades\Codashop;
use Illuminate\Testing\Fluent\AssertableJson;

describe("API Response", function () {
    it("should ok and have exact shape of response", function () {
        Codashop::shouldReceive("mlbb")->once()->andReturn([
            "success" => true,
            "confirmationFields" => [
                "productName" => "Mobile Legends: Bang Bang",
                "username" => "Jane Doe",
            ],
            "user" => [
                "userId" => "123456789",
                "zoneId" => "1234",
            ],
        ]);

        /**
         * @var \Illuminate\Testing\TestResponse $response
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson("/cek-ign/mlbb?id=123456789&zone=1234");

        $response->assertStatus(200)->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                "success",
                "code",
                "data.game",
                "data.account.ign",
                "data.account.id",
                "data.account.zone",
            ]);
        });
    });

    it("should 404 and have exact shape of response", function () {
        Codashop::shouldReceive("mlbb")->once()->andReturn([
            "success" => false
        ]);

        /**
         * @var \Illuminate\Testing\TestResponse $response
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson("/cek-ign/mlbb?id=0&zone=0");

        $response->assertStatus(404)->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                "success",
                "code",
                "error.name",
                "error.message"
            ]);
        });
    });
});

describe("Validation", function () {
    test("missing id from query", function () {
        /**
         * @var \Illuminate\Testing\TestResponse $response
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson("/cek-ign/mlbb?zone=0");

        $response->assertStatus(400)->assertJson(function (AssertableJson $json) {
            $json->hasAll(["success", "code"])->has("errors", 1, function (AssertableJson $json) {
                $json->where("path", "id")->where("message", "The id field is required.");
            });
        });
    });

    test("missing zone from query", function () {
        /**
         * @var \Illuminate\Testing\TestResponse $response
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson("/cek-ign/mlbb?id=0");

        $response->assertStatus(400)->assertJson(function (AssertableJson $json) {
            $json->hasAll(["success", "code"])->has("errors", 1, function (AssertableJson $json) {
                $json->where("path", "zone")->where("message", "The zone field is required.");
            });
        });
    });

    test("missing both id and zone from query", function () {
        /**
         * @var \Illuminate\Testing\TestResponse $response
         * @var \Tests\TestCase $this
         */
        $response = $this->getJson("/cek-ign/mlbb");

        $response->assertStatus(400)->assertJson(function (AssertableJson $json) {
            $json->hasAll(["success", "code"])->has("errors", 2, function (AssertableJson $json) {
                $json->hasAll(["path", "message"]);
            });
        });
    });
});
