<?php

namespace App\Models;

final class Dice
{
    public const FACES = [4,6,8,10,12,13,14,15,16,17,18,19,20];
    public const FACE_DEFAULT = 6;
    public const QUANTITY_DEFAULT = 1;
    public const QUANTITY_LIMIT = 5;

    public function __construct(int $quantity = 1, int $face = 6)
    {
        $this->face = $face === 0 ? self::FACE_DEFAULT : $face;
        $this->quantity = $quantity === 0 ? self::QUANTITY_DEFAULT : $quantity;
    }

    public function play(): array
    {
        $data = ['dice' => []];
        if (! $this->isValidQuantity() || ! $this->isValidFace()) {
            return $data;
        }

        $data['dice'] = $this->roll();
        return $data;
    }

    public function isValidQuantity(): bool
    {
        return $this->quantity > 0 && $this->quantity <= self::QUANTITY_LIMIT;
    }

    public function isValidFace(): bool
    {
        return in_array($this->face, self::FACES);
    }

    private function roll(): array
    {
        $i = 0;
        $data = [];
        while ($i < $this->quantity) {
            $data[] = rand(1, $this->face);
            $i++;
        }

        return $data;
    }
}
