<?php

namespace App\Http\Controllers;

use App\Facades\Check;
use App\Traits\HasResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
}
