<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use dacoto\EnvSet\Facades\EnvSet;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Provides default settings for all controllers
     * extended by controller
     *
     * @return object
     */
    protected function master(): object
    {
        return Setting::find(1);
    }

    /**
     * System configuration
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return mixed
     */
    public function protection(Request $request)
    {
        EnvSet::setKey(strtoupper('app_pack'), $request->package_hash ?? null);
        EnvSet::save();
        return redirect('/admin?message=Application_configuration_saved_successfully');
    }

    /**
     * DataTable sorting for common resources
     *
     * @param mixed $request
     *
     * @return array
     */
    protected function sort($request): array
    {
        return $request->get('sort', json_decode(json_encode(['order' => 'asc', 'column' => 'created_at']),
            true,
            512,
            JSON_THROW_ON_ERROR
        ));
    }

    /**
     * Generate pagination for common dataTables
     *
     * @param \Illuminate\Database\Eloquent\Collection $items
     *
     * @return array
     */
    protected function pagination($items): array
    {
        return [
            'currentPage' => $items->currentPage(),
            'perPage' => $items->perPage(),
            'total' => $items->total(),
            'totalPages' => $items->lastPage(),
        ];
    }

    protected function channelConfigs($user)
    {
        return $this->master()->getNotificationConfig($user);
    }

    protected function getUsers($admin = false)
    {
        return User::where('role_id', 1)->where('status', true)->get();
    }

    protected function getOrderTakers()
    {
        return User::where('role_id', 2)->where('status', true)->get();
    }

    protected function getChefs()
    {
        return User::where('role_id', 3)->where('status', true)->get();
    }

    protected function getBillers($admin = false)
    {
        return User::where('role_id', 4)->where('status', true)->get();
    }

    protected function getCurrentTimpstamp()
    {
        return Carbon::now();
    }

    protected function getTrackingIdentity()
    {
        $last = Sale::latest()->first();
        if (!$last) {
            $key = 1;
        } else {
            $key = $last->id;
        }
        return Date('Y') . Date('m') . '000'+$key;
    }
}
