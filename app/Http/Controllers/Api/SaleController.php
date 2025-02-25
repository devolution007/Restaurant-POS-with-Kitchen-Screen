<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Http\Resources\PosServiceTableResource;
use App\Http\Resources\PosStaffResource;
use App\Http\Resources\SaleDetailResource;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Models\ServiceTable;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request): JsonResponse
    {
        $sort = $this->sort($request);
        $sales = Sale::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items' => SaleResource::collection($sales->items()),
                'pagination' => $this->pagination($sales),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['order_taker_id'] = auth()->user()->id;
        $validated['took_at'] = $this->getCurrentTimpstamp();
        $validated['uuid'] = Str::orderedUuid();
        $validated['tracking'] = $this->getTrackingIdentity();
        if ('dining' == $validated['order_type'] && $this->checkTableIsServing($validated)) {
            return response()->json([
                'message' => __('Attention! Table is being served'),
            ], 422);
        }
        $sale = Sale::create($validated);
        $sale->serviceTable()->update(['is_booked' => true]);
        return response()->json([
            'message' => __('Order created successfully'),
            'order' => $sale->uuid,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\Sale  $sale   The sale
     *
     * @return     JsonResponse      The json response.
     */
    public function show(Sale $sale): JsonResponse
    {
        return response()->json(new SaleDetailResource($sale));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(SaleUpdateRequest $request, Sale $sale)
    {

        $validated = $request->validated();
        $validated['chef'] = null;
        $validated['prepared_at'] = null;
        if ('dining' == $validated['order_type'] && $validated['table_id'] !== $sale->serviceTable->id && $this->checkTableIsServing($validated)) {
            return response()->json([
                'message' => __('Attention! Table is being served'),
            ], 422);
        }
        $sale->serviceTable()->update(['is_booked' => false]);
        $sale->update($validated);
        $sale->serviceTable()->update(['is_booked' => true]);
        return response()->json([
            'message' => __('Order updated successfully'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale): JsonResponse
    {
        if (!\Auth::user()->userRole->checkPermission('remove_sales')) {
            return response()->json([
                'message' => __('You have not permit to perform this request'),
            ], 403);
        }
        if ('dining' === $sale->order_type) {
            $sale->serviceTable()->update(['is_booked' => false]);
        }
        $sale->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }

    public function checkTableIsServing($validated): Bool
    {
        $table = ServiceTable::where('is_booked', true)->where('id', $validated['table_id'])->first();
        return $table ? true : false;
    }

    public function filters(): JsonResponse
    {
        $users = User::get();
        return response()->json([
            'tables' => PosServiceTableResource::collection(ServiceTable::get()),
            'billers' => PosStaffResource::collection($this->getBillers()),
            'takers' => PosStaffResource::collection($this->getOrderTakers()),
            'chefs' => PosStaffResource::collection($this->getChefs()),
        ]);
    }
}
