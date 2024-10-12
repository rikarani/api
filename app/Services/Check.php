<?php

namespace App\Services;

use App\Contracts\Game;
use App\Facades\Codashop;
use App\Traits\HasResponse;

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
}
