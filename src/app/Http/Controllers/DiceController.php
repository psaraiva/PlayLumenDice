<?php

namespace App\Http\Controllers;

use App\Helpers\MimeType;
use App\Http\Resources\DiceResource;
use App\Models\Dice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \InvalidArgumentException;
use \Exception;

class DiceController extends Controller
{
    public function play(Request $request)
    {
        $acceptAllowed = [
            MimeType::TYPE_JSON => MimeType::getByType(MimeType::TYPE_JSON),
            MimeType::TYPE_PNG => MimeType::getByType(MimeType::TYPE_PNG),
        ];

        try {
            $accept = (string) $request->header('accept');
            $type = MimeType::getTypeSuported($accept, $acceptAllowed);
        } catch (InvalidArgumentException $e) {
            return response()->json([], 415);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        $this->validate($request, [
            'quantity' => 'nullable|numeric|between:0,10',
            'face' => [
                'nullable',
                Rule::in(config('dice.face.allowed')),
            ],
        ]);

        $method = 'play' . $type;
        if (! method_exists($this, $method)) {
            return response('', 415);
        }

        $result = $this->rollDice((int) $request->quantity, (int) $request->face);
        return $this->$method($result);
    }

    protected function rollDice(int $quantity, int $face): array
    {
        $dice = new Dice($quantity, $face);
        return $dice->play();
    }

    protected function playJson(array $dices): JsonResponse
    {
        if (count($dices['dice']) == 0) {
            return response('', 422);
        }

        return response()->json(DiceResource::make($dices), 200);
    }

    protected function playPng(array $dices)
    {
        $dice = new DiceResource($dices);
        return response($dice->toPng(), 200)
            ->header('Content-Type', MimeType::getByType(MimeType::TYPE_PNG));
    }
}
