<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Company $company */
        $company = $this->resource;

        return [
            'code' => $company->code,
            'name' => $company->name,
            'ico' => $company->crn,
            'dic' => $company->vat,
            'address' => new AddressResource($company->address),
        ];
    }
}
