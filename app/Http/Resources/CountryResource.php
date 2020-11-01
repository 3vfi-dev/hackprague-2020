<?php

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Country $country */
        $country = $this->resource;

        return [
            'id' => $country->getKey(),
            'name' => $country->name,
        ];
    }
}
