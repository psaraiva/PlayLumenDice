<?php
declare(strict_types=1);

namespace App\Models;

final class Dice
{
    public function __construct(int $quantity = 1, int $face = 6)
    {
        $this->face = $face === 0 ? config('dice.face.default') : $face;
        $this->quantity = $quantity === 0 ? config('dice.quantity.default') : $quantity;
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
        return $this->quantity > 0 && $this->quantity <= config('dice.quantity.limit');
    }

    public function isValidFace(): bool
    {
        return in_array($this->face, config('dice.face.allowed'));
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
