<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Dice;

class DiceController extends Controller
{
    public function play(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'nullable|min:1|max:50',
            'face' => [
                'nullable',
                Rule::in(Dice::FACES)
            ],
        ]);

        $result = Dice::play((int) $request->quantity, (int) $request->face);
        if (empty($result['dice'])) {
            return response()->json([], 422);
        }

        return response()->json($result, 200);
    }
}
