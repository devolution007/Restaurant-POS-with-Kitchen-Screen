<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Dashboard states
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     JsonResponse              The json response.
     */
    public function states(Request $request): JsonResponse
    {
        $orders = Sale::filter($request->all())->whereNotNull('completed_at')->get();
        $collection = collect($orders);
        return response()->json(
            [
                'total_price_amount' => $collection->sum('cart_total_price'), //+
                'total_cost_amount' => $collection->sum('cart_total_cost'), //+
                'total_discount_amount' => $collection->sum('discount_amount'), //-
                'total_payable_amount' => $collection->sum('payable_after_all'), //=
                'totla_profit_amount' => $collection->sum('profit_after_all'), //?
                'total_tax_amount' => $collection->sum('tax_amount'), //+
            ]
        );
    }

    /**
     * Dashboard annual graph
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     JsonResponse              The json response.
     */
    public function annualGraph(Request $request): JsonResponse
    {
        $graph = [];
        $month = 1;
        while ($month <= 12) {
            $graph[] = Sale::filter($request->all())->whereNotNull('completed_at')
                ->whereMonth('created_at', '=', $month)
                ->count();
            $month++;
        }
        return response()->json($graph);
    }
}
