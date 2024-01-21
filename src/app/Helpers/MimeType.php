<?php
declare(strict_types=1);

namespace App\Helpers;

use \InvalidArgumentException;

final class MimeType {

    public const TYPE_JSON = 'Json';
    public const TYPE_PNG = 'Png';
    public const TYPE_SVG = 'Svg';

    public const LIST = [
        self::TYPE_JSON => 'application/json',
        self::TYPE_PNG => 'image/png',
        self::TYPE_SVG => 'image/svg+xml',
    ];

    public static function getByType(string $type): string
    {
        if (! array_key_exists($type, self::LIST)) {
            throw new InvalidArgumentException();
        };

        return self::LIST[$type];
    }

    public static function getTypeSuported(string $accept, array $acceptExpected): string
    {
        foreach($acceptExpected as $type => $expected) {
            if (self::isSuported($accept, [$expected])) {
                return $type;
            }
        }

        throw new InvalidArgumentException();
    }

    public static function isSuported(string $accept, array $acceptExpected): bool
    {
        $prefix = 'init:';
        $accept = $prefix . (string) strtolower($accept);
        if (strlen($accept) == strlen($prefix)) {
            return false;
        }
    
        foreach ($acceptExpected as $expected) {
            if (strpos($accept, $expected) > 0) {
                return true;
            }
        }
    
        return false;
    }

    public static function isJson(string $accept): bool
    {
        return self::isSuported($accept, [self::getByType(self::TYPE_JSON)]);
    }

    public static function isPng(string $accept): bool
    {
        return self::isSuported($accept, [self::getByType(self::TYPE_PNG)]);
    }

    public static function isSvg(string $accept): bool
    {
        return self::isSuported($accept, [self::getByType(self::TYPE_SVG)]);
    }
}
