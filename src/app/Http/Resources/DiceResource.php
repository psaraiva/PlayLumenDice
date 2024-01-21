<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Helpers\DiceImage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (! is_array($this->resource)) {
            $this->resource = [];
        }

        return $this->resource;
    }

    public function toPng()
    {
        if (! is_array($this->resource)) {
            $this->resource = [];
        }

        return DiceImage::make($this->resource, Storage::disk('local'));
    }
}
