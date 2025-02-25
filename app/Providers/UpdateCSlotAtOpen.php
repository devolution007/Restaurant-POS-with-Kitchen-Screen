<?php

namespace App\Providers;

use App\Providers\CSlotOpened;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCSlotAtOpen
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\CSlotOpened  $event
     * @return void
     */
    public function handle(CSlotOpened $event)
    {
        //
    }
}
