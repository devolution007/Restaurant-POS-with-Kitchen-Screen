<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserRoleResource;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
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
     * User list for management
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return JsonResponse              The json response.
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $this->sort($request);
        $users = User::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items' => UserResource::collection($users->items()),
                'pagination' => $this->pagination($users),
            ]
        );
    }

    /**
     * Store to database
     *
     * @param UserStoreRequest $request request
     *
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($request->password);
        $user = User::create($validated);
        return response()->json(
            [
                'message' => __('Data saved successfully'),
                'user' => new UserResource($user),
            ]
        );
    }

    /**
     * Display specific user
     *
     * @param \App\Models\User $user The user
     *
     * @return JsonResponse      The json response.
     */
    public function show(User $user): JsonResponse
    {
        if (Auth::id() === $user->id) {
            return response()->json(
                ['message' => __('Can not edit your user from the user manager')],
                406
            );
        }
        return response()->json(new UserResource($user));
    }

    /**
     * Update specific user's information
     *
     * @param \App\Http\Requests\UserUpdateRequest $request The request
     * @param \App\Models\User                     $user    The user
     *
     * @return JsonResponse                          The json response.
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());
        return response()->json(
            [
                'message' => __('Data updated successfully'),
            ]
        );
    }

    /**
     * Destroys the given user.
     *
     * @param \App\Models\User $user The user
     *
     * @return JsonResponse      The json response.
     */
    public function destroy(User $user): JsonResponse
    {
        if (Auth::id() === $user->id) {
            return response()->json(
                ['message' => __('You can not delete your own user')],
                406
            );
        }
        $user->delete();
        return response()->json(
            ['message' => __('Data removed successfully')]
        );
    }

    /**
     *  User roles list
     *
     * @return JsonResponse  The json response.
     */
    public function userRoles(): JsonResponse
    {
        return response()->json(UserRoleResource::collection(UserRole::get()));
    }
}
