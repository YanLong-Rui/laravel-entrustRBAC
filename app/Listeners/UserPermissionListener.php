<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UserPermission;
use App\User;
use Illuminate\Support\Facades\Cache;

class UserPermissionListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(UserPermission $event)
    {
        $menu = User::instance()->getMenu($event->id);
        Cache::forget('menu');
        Cache::forever('menu',$menu);
    }
}
