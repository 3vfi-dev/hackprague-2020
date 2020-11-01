<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\ReceiptProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Product $product */
        $product = $this->resource;
        /** @var ReceiptProduct $pivot */
        $pivot = $product->pivot;

        $warranty = $pivot->created_at->addMonths($pivot->warranty)->toDateString();
        $additionalText = $this->getAdditionalText($warranty);

        return [
            'code' => $product->code,
            'name' => $product->name,
            'category' => new CategoryResource($product->category),
            'vat' => $pivot->vat,
            'quantity' => $pivot->quantity,
            'additional_text' => $additionalText,
            'price' => $pivot->price,
            'price_with_vat' => $pivot->price_with_vat,
            'price_total' => $pivot->price_total,
            'price_with_vat_total' => $pivot->price_with_vat_total,
            'warranty_till' => $warranty,
        ];
    }

    /**
     * Get an additional text for the product.
     *
     * @param  string  $warranty
     * @return string|null
     */
    protected function getAdditionalText(string $warranty): ?string
    {
        /** @var Product $product */
        $product = $this->resource;
        /** @var ReceiptProduct $pivot */
        $pivot = $product->pivot;

        if ($product->quantity_text) {
            return number_format($pivot->price_with_vat, 1, ',', ' ') . ' Kč / ' . $product->quantity_text;
        } elseif ($product->category->warranty_text) {
            return trans('products.warranty_till', ['date' => $warranty]);
        }

        return null;
    }
}
