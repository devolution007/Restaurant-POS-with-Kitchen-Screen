<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SaleReportResource;
use App\Http\Resources\StockAlertResource;
use App\Models\Expense;
use App\Models\Ingredient;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends ApiController
{

    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function tax(Request $request): JsonResponse
    {
        $graph = [];
        $month = 1;
        while ($month <= 12) {
            $graph[] = Sale::filter($request->all())->whereNotNull('completed_at')
                ->whereYear('created_at', '=', $request->year ?? date('Y'))
                ->whereMonth('created_at', '=', $month)
                ->sum('tax_amount');
            $month++;
        }
        return response()->json($graph);
    }

    public function expense(Request $request): JsonResponse
    {
        $graph = [];
        $month = 1;
        while ($month <= 12) {
            $graph[] = Expense::whereYear('created_at', '=', $request->year ?? date('Y'))
                ->whereMonth('created_at', '=', $month)
                ->sum('amount');
            $month++;
        }
        return response()->json($graph);
    }

    public function stockAlerts(Request $request): JsonResponse
    {
        $items = Ingredient::outOfStock()->get();
        return response()->json(StockAlertResource::collection($items));
    }

    public function generate(Request $request): JsonResponse
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
                'orders' => $collection->count(),
                'list' => SaleReportResource::collection($orders),
            ]
        );
    }
}
