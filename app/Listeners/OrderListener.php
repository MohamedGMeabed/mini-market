<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use App\Models\Order;
use App\Notifications\SendNotifyToUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class OrderListener
{
    public $order;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderEvent $event)
    {
        $user = auth()->user();      
        Notification::send($user,new SendNotifyToUser($this->order));
        
    }
}
