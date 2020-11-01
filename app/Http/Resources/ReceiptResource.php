<?php

namespace App\Http\Resources;

use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    /**
     * Whether products should be included in the result array.
     *
     * @var bool
     */
    protected static $withProducts = true;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Receipt $receipt */
        $receipt = $this->resource;

        return [
            'fik' => $receipt->fik,
            'bkp' => $receipt->bkp,
            'pkp' => $receipt->pkp,
            'cash_register' => $receipt->cash_register,
            'receipt_number' => $receipt->receipt_number,
            'custom_text' => $receipt->custom_text,
            'company' => new CompanyResource($receipt->company),
            $this->mergeWhen(static::$withProducts, [
                'products' => ProductReceiptResource::collection($receipt->products),
            ]),
            'price_total' => $receipt->price_total,
            'price_with_vat_total' => $receipt->price_with_vat_total,
            'products_quantity' => $receipt->products_quantity,
            'paid_at' => (new Carbon($receipt->paid_at))->format(DATE_ATOM),
        ];
    }

    /**
     * Remove products from the result array.
     *
     * @return void
     */
    public static function withoutProducts(): void
    {
        static::$withProducts = false;
    }
}
