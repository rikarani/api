<?php

namespace App\Services;

use App\Contracts\Game;
use Illuminate\Support\Facades\Http;

class Codashop implements Game
{
    private $url = 'https://order-sg.codashop.com/initPayment.action';

    public function mlbb(string $id, string $zone)
    {
        $response = $this->hit($this->url, [
            'voucherPricePoint.id' => '27684',
            'voucherPricePoint.price' => '527250',
            'voucherPricePoint.variablePrice' => '0',
            'user.userId' => $id,
            'user.zoneId' => $zone,
            'voucherTypeName' => 'MOBILE_LEGENDS',
            'shopLang' => 'id_ID',
        ]);

        return $response;
    }

    public function genshin(string $uid, ?string $server)
    {
        $response = $this->hit($this->url, [
            'voucherPricePoint.id' => '116054',
            'voucherPricePoint.price' => '16500',
            'voucherPricePoint.variablePrice' => '0',
            'user.userId' => $uid,
            'user.zoneId' => $server,
            'voucherTypeName' => 'GENSHIN_IMPACT',
            'shopLang' => 'id_ID',
        ]);

        return $response;
    }

    private function hit(string $url, array $data)
    {
        return Http::asForm()->withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Origin' => 'https://www.codashop.com',
            'Referer' => 'https://www.codashop.com/',
        ])->post($url, $data)->json();
    }
}
