<?php

namespace App\Providers;

use App\Events\ProductAdded;
use App\Listeners\SendProductNotification;

use App\Events\LoginUser;
use App\Listeners\LoginHistory;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
         ProductAdded::class => [
            SendProductNotification::class,
        ],
         LoginUser::class => [
            LoginHistory::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
