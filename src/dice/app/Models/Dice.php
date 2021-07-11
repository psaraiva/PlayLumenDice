<?php

namespace App\Models;

class Dice
{
    const FACES = [4,6,8,10,12,13,14,15,16,17,18,19,20];
    const FACE_DEFAULT = 6;
    const QUANTITY_LIMIT = 5;

    public static function play(int $quantity, int $face = self::FACE_DEFAULT): array
    {
        $data = ['dice'=>[]];
        $face = ($face == 0) ? self::FACE_DEFAULT : $face;
        if (!self::isValidQuantity($quantity) || !self::isValidFace($face)) {
            return $data;
        }

        $i=0;
        while ($i < $quantity) {
            $data['dice'][] = rand(1, $face);
            $i++;
        }

        return $data;
    }

    public static function isValidQuantity($quantity): bool
    {
        $quantity = (int) $quantity;
        return $quantity > 0 && $quantity <= self::QUANTITY_LIMIT;
    }

    public static function isValidFace($face): bool
    {
        return in_array((int) $face, self::FACES);
    }
}
