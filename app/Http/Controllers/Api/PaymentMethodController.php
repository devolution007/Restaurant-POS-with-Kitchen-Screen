<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentMethodController extends ApiController
{

    /**
     * Construct middleware and initiated backups list
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(['update', 'destroy']);
    }

    /**
     * Payment methods list
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     JsonResponse              The json response.
     */
    public function index(Request $request): JsonResponse
    {
        $methods = PaymentMethod::latest()->get();
        return response()->json(PaymentMethodResource::collection($methods));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\PaymentMethodStoreRequest  $request  The request
     *
     * @return     JsonResponse                                  The json response.
     */
    public function store(PaymentMethodStoreRequest $request): JsonResponse
    {
        $paymentMethod = PaymentMethod::create($request->validated());
        return response()->json([
            'message' => __('Data saved successfully'),
            'method' => $paymentMethod->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\PaymentMethod  $paymentMethod  The payment method
     *
     * @return     JsonResponse               The json response.
     */
    public function show(PaymentMethod $paymentMethod): JsonResponse
    {
        return response()->json(new PaymentMethodResource($paymentMethod));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\PaymentMethodUpdateRequest  $request        The request
     * @param      \App\Models\PaymentMethod                      $paymentMethod  The payment method
     *
     * @return     JsonResponse                                   The json response.
     */
    public function update(PaymentMethodUpdateRequest $request, PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->update($request->validated());
        return response()->json([
            'message' => __('Data updated successfully'),
            'method' => $paymentMethod->id,
        ]);
    }

    /**
     * Destroys the given payment method.
     *
     * @param      \App\Models\PaymentMethod  $paymentMethod  The payment method
     *
     * @return     JsonResponse               The json response.
     */
    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }
}
