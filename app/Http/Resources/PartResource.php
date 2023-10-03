<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => (int)$this->price,
            'img' => $this->img,
            'imgs' => explode("|", $this->imgs),
            'cars' => explode("|", $this->cars),
            'des' => $this->des,
        ];
    }
}