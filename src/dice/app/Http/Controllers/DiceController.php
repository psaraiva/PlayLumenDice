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
            'quantity' => 'required|min:1|max:50',
            'face' => [
                'nullable',
                Rule::in(Dice::FACES)
            ],
        ]);

        $result = Dice::play($request->quantity, (int) $request->face);
        return response()->json($result, 200);
    }
}
