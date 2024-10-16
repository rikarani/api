<?php

namespace App\Http\Controllers;

use App\Facades\Check;
use App\Enums\Genshin;
use App\Helpers\Server;
use App\Traits\HasResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CheckController extends Controller
{
    use HasResponse;

    public function mlbb(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|numeric',
                'zone' => 'required|numeric',
            ]);

            return Check::mlbb($validated['id'], $validated['zone']);
        } catch (ValidationException $e) {
            $errors = Collection::make($e->errors())->map(function ($error, $key) {
                return [
                    'path' => $key,
                    'message' => $error[0],
                ];
            });

            return $this->badRequest($errors->values());
        }
    }

    public function genshin(Request $request)
    {
        try {
            $validated = $request->validate([
                'uid' => "required|numeric",
            ]);

            $server = Server::genshin($validated['uid']);

            if (!$server) {
                throw ValidationException::withMessages([
                    'uid' => "Invalid UID"
                ]);
            }

            return Check::genshin($validated['uid'], $server->value);
        } catch (ValidationException $e) {
            $errors = Collection::make($e->errors())->map(function ($error, $key) {
                return [
                    'path' => $key,
                    'message' => $error[0],
                ];
            });

            return $this->badRequest($errors->values());
        }
    }
}
