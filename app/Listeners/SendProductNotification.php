<?php

namespace App\Listeners;

use App\Events\ProductAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;


class SendProductNotification
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
     * @param  ProductAdded  $event
     * @return void
     */
    public function handle(ProductAdded $event)
    {
        $product_info = $event->product;

        $save_notification = Notification::create(['p_id'=>$product_info->id]);

        return $save_notification;
    }
}
