<?php

namespace App\Contracts;

interface Game
{
    public function mlbb(string $id, string $zone);
    public function genshin(string $uid, string $server);
}
