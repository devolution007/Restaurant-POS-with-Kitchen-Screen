<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SaleOrderPrintResource;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;

class InvoicePrintController extends ApiController
{
    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('reportCard');
    }

    /**
     * Display the specified resource.
     *
     * @param      Sale          $sale   The sale
     *
     * @return     JsonResponse  The json response.
     */
    public function sale(Sale $sale): JsonResponse
    {
        return response()->json(new SaleOrderPrintResource($sale));
    }

}
