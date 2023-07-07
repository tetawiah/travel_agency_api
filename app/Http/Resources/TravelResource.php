<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
            "slug" => $this->slug,
            "name" => $this->name,
            "description" => $this->description,
            "numOfDays" => $this->num_of_days,
            "numOfNights" => $this->num_of_nights,
        ];
    }
}
