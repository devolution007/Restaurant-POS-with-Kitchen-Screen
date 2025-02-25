<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRoleStoreRequest;
use App\Http\Requests\UserRoleUpdateRequest;
use App\Http\Resources\UserRoleEditResource;
use App\Http\Resources\UserRoleResource;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserRoleController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware(
            'demo',
            ['only' => ['update', 'destroy']]
        );
    }

    /**
     * User roles list for management
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return JsonResponse              The json response.
     */

    public function index(Request $request): JsonResponse
    {
        $sort = $this->sort($request);
        $roles = UserRole::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items' => UserRoleResource::collection($roles->items()),
                'pagination' => $this->pagination($roles),
            ]
        );
    }

    /**
     * Store role to database
     *
     * @param \App\Http\Requests\UserRoleStoreRequest $request The request
     *
     * @return JsonResponse                             The json response.
     */
    public function store(UserRoleStoreRequest $request): JsonResponse
    {
        $userRole = UserRole::create($request->validated());
        return response()->json(
            [
                'message' => __('Data saved successfully'),
                'userRole' => new UserRoleEditResource($userRole),
            ]
        );
    }

    /**
     * Display specific role
     *
     * @param \App\Models\UserRole $userRole The user role
     *
     * @return JsonResponse          The json response.
     */
    public function show(UserRole $userRole): JsonResponse
    {
        if ($userRole->is_primary) {
            return response()->json(
                ['message' => __('Cannot edit a system base function')],
                406
            );
        }
        return response()->json(new UserRoleEditResource($userRole));
    }

    /**
     * Update user role
     *
     * @param \App\Http\Requests\UserRoleUpdateRequest $request  The request
     * @param \App\Models\UserRole                     $userRole The user role
     *
     * @return JsonResponse                              The json response.
     */
    public function update(UserRoleUpdateRequest $request, UserRole $userRole): JsonResponse
    {
        $userRole->update($request->validated());
        return response()->json(
            [
                'message' => __('Data updated successfully'),
            ]
        );
    }

    /**
     * Destroys the given user role.
     *
     * @param \App\Models\UserRole $userRole The user role
     *
     * @return JsonResponse          The json response.
     */
    public function destroy(UserRole $userRole): JsonResponse
    {
        if ($userRole->is_primary || ((int) $this->master()->app_default_role === $userRole->id)) {
            return response()->json(
                ['message' => __('Can not delete a default role')],
                406
            );
        }
        User::where('role_id', $userRole->id)->update(
            ['role_id' => $this->master()->app_default_role]
        );
        $userRole->delete();
        return response()->json(
            ['message' => __('Data removed successfully')]
        );
    }

    /**
     * Gives permissions keys
     *
     * @return JsonResponse  The json response.
     */
    public function permissions(): JsonResponse
    {
        return response()->json(
            [
                ['key' => 'dashboard_access', 'label' => __('Dashboard access')],
                ['key' => 'manage_sales', 'label' => __('Manage sales')],
                ['key' => 'remove_sales', 'label' => __('Remove sale order')],

                //portal
                ['title' => true, 'label' => __('Portal area')],
                ['key' => 'pos_portal', 'label' => __('POS portal')],
                ['key' => 'order_checkout', 'label' => __('Allow to proccess billing in POS portal')],
                ['key' => 'kitchen_portal', 'label' => __('Kichen portal')],

                //food
                ['title' => true, 'label' => __('Food area')],
                ['key' => 'manage_food_categories', 'label' => __('Manage food category')],
                ['key' => 'manage_food_items', 'label' => __('Manage food items')],
                ['key' => 'manage_modifiers', 'label' => __('Manage modifiers')],
                ['key' => 'manage_ingredients', 'label' => __('Manage ingredients')],

                //expenses
                ['title' => true, 'label' => __('Expense area')],
                ['key' => 'manage_expense_types', 'label' => __('Manage expense types')],
                ['key' => 'manage_expenses', 'label' => __('Manage expenses')],

                //People
                ['title' => true, 'label' => __('People area')],
                ['key' => 'manage_users', 'label' => __('Manage users')],
                ['key' => 'manage_user_roles', 'label' => __('Manage user roles')],
                ['key' => 'manage_customers', 'label' => __('Manage customers roles')],

                //reports
                ['title' => true, 'label' => __('Reports area')],
                ['key' => 'overall_report', 'label' => __('Overall report')],
                ['key' => 'tax_report', 'label' => __('Tax report')],
                ['key' => 'expense_report', 'label' => __('Expense report')],
                ['key' => 'stock_alerts', 'label' => __('Stock alerts')],

                //advance
                ['title' => true, 'label' => __('Advance area')],
                ['key' => 'import_exports', 'label' => __('Import and exports')],
                ['key' => 'manage_service_tables', 'label' => __('Manage service tables')],
                ['key' => 'manage_payment_methods', 'label' => __('Manage payment methods')],
                ['key' => 'database_backup', 'label' => __('Database backup')],
                ['key' => 'manage_languages', 'label' => __('Manage Languages')],

                //Settings
                ['title' => true, 'label' => __('Configuration area')],
                ['key' => 'general_configuration', 'label' => __('General configuration')],
                ['key' => 'appearance_configuration', 'label' => __('Appearance configuration')],
                ['key' => 'localization_configuration', 'label' => __('Localization configuration')],
                ['key' => 'outgoing_mail_configuration', 'label' => __('Outgoing mail configuration')],
                ['key' => 'currency_configuration', 'label' => __('Currency configuration')],
                ['key' => 'authentication_configuration', 'label' => __('Authentication configuration')],
                ['key' => 'captcha_configuration', 'label' => __('Captcha configuration')],
                ['key' => 'tax_configuration', 'label' => __('Captcha configuration')],
            ]
        );
    }
}
