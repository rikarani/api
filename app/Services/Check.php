<?php

namespace App\Services;

use App\Enums\Genshin;
use App\Contracts\Game;
use App\Helpers\Server;
use App\Facades\Codashop;
use App\Traits\HasResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;

class Check implements Game
{
    use HasResponse;

    public function mlbb(string $id, string $zone)
    {
        $response = Codashop::mlbb($id, $zone);

        if (! $response['success']) {
            return $this->notFound();
        }

        $data = [
            'game' => $response['confirmationFields']['productName'],
            'account' => [
                'ign' => $response['confirmationFields']['username'],
                'id' => $response['user']['userId'],
                'zone' => $response['user']['zoneId'],
            ],
        ];

        return $this->ok(collect($data));
    }

    public function genshin(string $uid, string $server)
    {
        $response = Codashop::genshin($uid, $server);

        if ($response["errorCode"] == "-100") {
            return $this->notFound();
        }

        $data = [
            "game" => $response["confirmationFields"]["productName"],
            "account" => [
                "ign" => $response["confirmationFields"]["username"],
                "uid" => $response["user"]["userId"],
                "server" => Genshin::tryFrom($response["user"]["zoneId"])->name
            ]
        ];

        return $this->ok(collect($data));
    }
}
