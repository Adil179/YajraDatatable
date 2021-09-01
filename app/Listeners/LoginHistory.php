<?php

namespace App\Listeners;

use App\Events\LoginUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginHistory
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
     * @param  LoginUser  $event
     * @return void
     */
    public function handle(LoginUser $event)
    {
        //
    }
}
