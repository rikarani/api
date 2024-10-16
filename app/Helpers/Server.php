<?php

namespace App\Helpers;

use App\Enums\Genshin;
use Illuminate\Support\Str;

class Server
{
    final public static function genshin(string $uid): Genshin|bool
    {
        if (Str::startsWith($uid, "6")) {
            return Genshin::America;
        } else if (Str::startsWith($uid, "7")) {
            return Genshin::Europe;
        } else if (Str::startsWith($uid, ["8", "18"])) {
            return Genshin::Asia;
        } else if (Str::startsWith($uid, "9")) {
            return Genshin::TW_HK_MO;
        }

        return false;
    }
}
