<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Receipt\StoreReceiptRequest;
use App\Http\Resources\ReceiptResource;
use App\Models\Company;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Throwable;

class ReceiptController extends Controller
{
    /**
     * Set middlewares to the actions.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client:check-receipts')->except(['store']);
        $this->middleware('check-receipts')->except(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();
        $receipts = $user->receipts()
            ->latest()
            ->with([
                'company',
                'company.address',
                'company.address.country',
            ])
            ->paginate(25);

        ReceiptResource::withoutProducts();

        return ReceiptResource::collection($receipts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Here should be an additional validation of PKP, FIK, and BKP connected
     * to the EET system. Unfortunately, that is not possible right now.
     *
     * @param  StoreReceiptRequest  $request
     * @return JsonResponse
     */
    public function store(StoreReceiptRequest $request): JsonResponse
    {
        $inputtedProducts = $request->input('products');
        $products = Product::with('category')->whereIn('code', Arr::pluck($inputtedProducts, 'code'))->get();

        $receipt = new Receipt($request->only(['hash', 'custom_text', 'pkp', 'fik', 'bkp']));
        $receipt->setAttribute('paid_at', $request->input('time'));
        $receipt->setAttribute('company_id', Company::whereCode($request->input('company'))->first()->getKey());
        $receipt->calculatePrices($inputtedProducts, $products);
        $receipt->save();

        foreach ($inputtedProducts as $data) {
            /** @var Product $product */
            $product = $products->where('code', $data['code'])->first();
            $receipt->attachProduct($product, $data['quantity'], $data['vat']);
        }

        return response()->json([
            'error' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Receipt  $receipt
     * @return ReceiptResource
     *
     * @throws UnauthorizedException
     * @throws Throwable
     */
    public function show(Receipt $receipt): ReceiptResource
    {
        throw_if($receipt->user_id !== Auth::guard('api')->id(), new UnauthorizedException);

        return (new ReceiptResource($receipt))->additional(['error' => false]);
    }
}
