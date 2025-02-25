<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\OrderProgressUpdateRequest;
use App\Http\Requests\PosCheckoutRequest;
use App\Http\Resources\PosBillingSaleOrderResource;
use App\Http\Resources\PosCustomerResource;
use App\Http\Resources\PosFoodCategoryResource;
use App\Http\Resources\PosFoodItemResource;
use App\Http\Resources\PosKitchenOrderResource;
use App\Http\Resources\PosModifierResource;
use App\Http\Resources\PosPaymentMethodResource;
use App\Http\Resources\PosServiceTableResource;
use App\Http\Resources\PosSubmittedSaleOrderResource;
use App\Models\Customer;
use App\Models\FoodCategory;
use App\Models\FoodItem;
use App\Models\Modifier;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\ServiceTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PosController extends ApiController
{

    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function products(Request $request): JsonResponse
    {
        $sort = $this->sort($request);
        $items = FoodItem::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 18));
        \Artisan::call('optimize:clear');
        return response()->json(
            [
                'items' => PosFoodItemResource::collection($items->items()),
                'pagination' => $this->pagination($items),
            ]
        );
    }

    public function paymentMethods(): JsonResponse
    {
        $methods = PaymentMethod::get();
        return response()->json(PosPaymentMethodResource::collection($methods));
    }

    public function serviceTables(): JsonResponse
    {
        $tables = ServiceTable::get();
        return response()->json(PosServiceTableResource::collection($tables));
    }

    public function modifiers(): JsonResponse
    {
        $modifiers = Modifier::get();
        return response()->json(PosModifierResource::collection($modifiers));
    }

    public function categories(Request $request): JsonResponse
    {
        $categories = FoodCategory::get();
        return response()->json(PosFoodCategoryResource::collection($categories));
    }

    public function kitchenOrders(Request $request): JsonResponse
    {
        $orders = Sale::filter($request->all())->orderForKitchen()->get();
        return response()->json([
            'orders' => PosKitchenOrderResource::collection($orders),
            'chefs' => $this->getChefs(),
        ]);
    }

    public function customers(Request $request): JsonResponse
    {
        $customers = Customer::get();
        return response()->json(PosCustomerResource::collection($customers));
    }

    public function submitedOrder(Request $request): JsonResponse
    {
        $order = Sale::where('uuid', $request->uuid)->submittedOrder()->first();
        if ($order) {
            return response()->json(new PosBillingSaleOrderResource($order));
        }
        return response()->json([
            'message' => __('Unable to process the request, order is completed'),
        ]);
    }

    public function submiitedOrders(): JsonResponse
    {
        $orders = Sale::latest()->submittedOrder()->get();
        return response()->json(PosSubmittedSaleOrderResource::collection($orders));
    }

    public function orderProgressUpdate(OrderProgressUpdateRequest $request, Sale $sale): JsonResponse
    {
        $validated = $request->validated();
        $sale->update([
            'progress' => $request->progress,
            'items' => $request->items,
            'chef_id' => $request->chef_id,
            'is_preparing' => $request->progress > 0 ? true : false,
            'prepared_at' => $request->progress > 99 ? $this->getCurrentTimpstamp() : null,
        ]);
        return response()->json([
            'message' => __('Order information updated successfully'),
        ]);
    }

    public function checkout(PosCheckoutRequest $request, Sale $sale): JsonResponse
    {
        $validated = $request->validated();
        $validated['completed_at'] = $this->getCurrentTimpstamp();
        $validated['biller_id'] = auth()->user()->id;
        if (!\Auth::user()->userRole->checkPermission('order_checkout')) {
            return response()->json([
                'message' => __('You have not permit to perform this request'),
            ], 403);
        }
        foreach ($sale->items as $item) {
            $this->proccessFoodModifierStock($item);
            $this->proccessFoodItemStock($item);
        }
        if ('dining' === $sale->order_type) {
            $sale->serviceTable()->update(['is_booked' => false]);
        }
        $sale->update($validated);
        \Artisan::call('optimize:clear');
        return response()->json([
            'message' => __('Processed successfully'),
        ]);
    }

    protected function proccessFoodItemStock($item)
    {
        $foodItem = FoodItem::where('uuid', $item['uuid'])->first();
        $this->adjustIngredientStock($foodItem->ingredients, $item['qty']);
    }

    protected function proccessFoodModifierStock($item)
    {
        foreach ($item['modifiers'] as $modifier) {
            $modifierObject = Modifier::where('id', $modifier['id'])->first();
            $this->adjustIngredientStock($modifierObject->ingredients, $modifier['qty']);
        }
    }

    protected function adjustIngredientStock($ingredients, $qty)
    {
        foreach ($ingredients as $ingredient) {
            $usingQty = $ingredient->pivot->quantity;
            $ingredient->quantity -= $usingQty * $qty;
            $ingredient->save();
        }
    }
}
