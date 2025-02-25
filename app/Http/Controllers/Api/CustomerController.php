<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends ApiController
{

    /**
     * Construct middleware and initiated backups list
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware('demo')->only(['update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $this->sort($request);
        $customers = Customer::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json(
            [
                'items' => CustomerResource::collection($customers->items()),
                'pagination' => $this->pagination($customers),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\CustomerStoreRequest  $request  The request
     *
     * @return     JsonResponse                             The json response.
     */
    public function store(CustomerStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['uuid'] = \Str::orderedUuid();
        $customer = Customer::create($validated);
        return response()->json([
            'message' => __('Data saved successfully'),
            'customer' => new CustomerResource($customer),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\Customer  $customer  The Customer
     *
     * @return     JsonResponse          The json response.
     */
    public function show(Customer $customer): JsonResponse
    {
        return response()->json(new CustomerResource($customer));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\CustomerUpdateRequest  $request   The request
     * @param      \App\Models\Customer                      $customer  The Customer
     *
     * @return     JsonResponse                              The json response.
     */
    public function update(CustomerUpdateRequest $request, Customer $customer): JsonResponse
    {
        $customer->update($request->validated());
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     * Destroys the given Customer.
     *
     * @param      \App\Models\Customer  $customer  The Customer
     *
     * @return     JsonResponse          The json response.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        if ($customer->id > 1 && $customer->sales->count() < 1) {
            $customer->delete();
            return response()->json([
                'message' => __('Data removed successfully'),
            ]);
        }
        return response()->json([
            'message' => __('Unable to remove customer information is being used'),
        ], 422);
    }

    public function customers(): JsonResponse
    {
        return response()->json(CustomerResource::collection(Customer::get()));
    }
}
