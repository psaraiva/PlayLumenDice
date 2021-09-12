<?php

namespace App\Helpers;

use \GdImage;
use Illuminate\Filesystem\FilesystemAdapter;

final class DiceImage {

    private const PATH_IMG = 'img/dice/';
    private const FILE_NAME_PATTERN = 'dice_face_0%d.png';
    private const FILE_NAME_DEFAULT = 'dice_face_00.png';

    public static function make(array $dices, FilesystemAdapter $fileSystem)
    {
        $imgs = self::getFileNameImgs($dices, $fileSystem);
        $finalImg = self::generateFinalImgBase($imgs);
        self::append($finalImg, $imgs);

        return self::getImgBuffer($finalImg);
    }

    private static function append(GdImage &$finalImg, array $imgs): void
    {
        $i = 0;
        list($x, $y) = self::getCoordinates($imgs[0]);
        foreach ($imgs as $imgFileName) {
            $gd = imagecreatefrompng($imgFileName);
            imagecopy($finalImg, $gd, ($i*$x), 0, 0, 0, $x, $y);
            $i++;
        }
    }

    private static function generateFinalImgBase(array $imgs): GdImage
    {
        list($x, $y) = self::getCoordinates($imgs[0]);
        $x *= count($imgs);

        $finalImg = imagecreatetruecolor($x, $y);
        imagealphablending($finalImg, true);
        imagesavealpha($finalImg, true);

        return $finalImg;
    }

    private static function getCoordinates(string $imgFileName): array
    {
        $imageSize = getimagesize($imgFileName);
        $y = $imageSize[1];
        $x = $imageSize[0];
        return [$x, $y];
    }

    private static function getFileNameImgs(array $dices, FilesystemAdapter $fileSystem): array
    {
        $imgs = [];
        foreach($dices['dice'] as $face) {
            $fileName = sprintf(self::FILE_NAME_PATTERN, $face);
            if (! $fileSystem->exists(self::PATH_IMG . $fileName)) {
                $fileName = self::FILE_NAME_DEFAULT;
            }

            $imgs[] = $fileSystem->path(self::PATH_IMG . $fileName);
        }

        return $imgs;
    }

    private static function getImgBuffer(GdImage $img)
    {
        ob_start();
        imagepng($img);
        $pngBuffer = ob_get_contents();
        ob_end_clean();
        
        return $pngBuffer;
    }
}
