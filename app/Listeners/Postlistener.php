<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Postnotificaciones;

class Postlistener
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
    public function handle($event)
    {
        User::all()
        ->except(session('user_id'))
        ->each(function(User $user) use($event){

            Notification::send($user,new Postnotificaciones($event->datos));
        
           
            //$user->notify(new PostNotification());
       }); 
    }
}
