<?php

namespace App\Http\Controllers;

use App\Models\Dice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiceController extends Controller
{
    public function play(Request $request): JsonResponse
    {
        $this->validate($request, [
            'quantity' => 'nullable|numeric|between:0,10',
            'face' => [
                'nullable',
                Rule::in(Dice::FACES),
            ],
        ]);

        $result = Dice::play((int) $request->quantity, (int) $request->face);
        if (count($result['dice']) < 1) {
            return response()->json([], 422);
        }

        return response()->json($result, 200);
    }
}
