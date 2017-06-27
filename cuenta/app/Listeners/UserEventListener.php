<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Log;
use App\Bitacora;

class UserEventListener
{



    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        Log::info('Showing user profile for user: ');
        $binnacle = new Bitacora();
        $binnacle->bitcta_users_id = $event->user->id;
        $binnacle->bitc_fecha = date("Y-m-d H:i:s");
        $binnacle->bitcta_tipo_op = 'access';
        $binnacle->bitcta_ip = $binnacle->getrealip();
        $browser_arr = $binnacle->getBrowser();
        $binnacle->bitcta_naveg = $browser_arr['name'].' '.$browser_arr['version'];
        $binnacle->bitc_modulo = '\Login';
        $binnacle->bitcta_result = 'TODO';
        $binnacle->bitcta_msg = 'Se ha accedido a la aplicación';
        $binnacle->bitcta_dato = json_encode($_REQUEST);
        $binnacle->save();
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {

    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventListener@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventListener@onUserLogout'
        );
    }

}    