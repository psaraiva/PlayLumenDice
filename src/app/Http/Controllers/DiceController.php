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
                Rule::in(config('dice.face.allowed')),
            ],
        ]);

        $dice = new Dice((int) $request->quantity, (int) $request->face);
        $result = $dice->play();
        if (count($result['dice']) == 0) {
            return response()->json([], 422);
        }

        return response()->json($result, 200);
    }
}
