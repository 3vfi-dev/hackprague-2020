<?php

namespace App\Http\Resources;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Address $address */
        $address = $this->resource;

        return [
            'street' => $address->street,
            'registry_number' => $address->registry_number,
            'house_number' => $address->house_number,
            'city' => $address->city,
            'country' => new CountryResource($address->country),
            'lat' => $address->lat,
            'lng' => $address->lng,
        ];
    }
}
