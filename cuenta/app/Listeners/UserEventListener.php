<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Log;
use App\Bitacora;
use App\User;

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
        $usr = User::find($event->user->id);

        $binnacle->bitcta_msg = 'Acceso de usuario '.$usr->name;
        $usr->users_f_ultacces = date('Y-m-d H:i:s');
        $usr->users_blocked = false;
        $usr->save();
        $binnacle->bitcta_dato = json_encode($_REQUEST);
        $binnacle->save();
    }


    public function onUserLoginFailed($event) {
        //Log::info($event->credentials);
        $email = $event->credentials['email'];
        $usr = User::where('email', '=', $email)->get();
        $binnacle = new Bitacora();
        $binnacle->bitcta_users_id = $usr[0]->id;
        $binnacle->bitc_fecha = date("Y-m-d H:i:s");
        $binnacle->bitcta_tipo_op = 'access failed';
        $binnacle->bitcta_ip = $binnacle->getrealip();
        $browser_arr = $binnacle->getBrowser();
        $binnacle->bitcta_naveg = $browser_arr['name'].' '.$browser_arr['version'];
        $binnacle->bitc_modulo = '\Login';
        $binnacle->bitcta_result = 'TODO';
        $usr = User::find($event->user->id);

        $binnacle->bitcta_msg = 'Intento de acceso fallido de usuario '.$usr->name;
        $usr->users_f_ultacces = date('Y-m-d H:i:s');
        $usr->save();
        $binnacle->bitcta_dato = json_encode($_REQUEST);
        $binnacle->save();
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        Log::info('Showing user profile for user: ');
        $binnacle = new Bitacora();
        $binnacle->bitcta_users_id = $event->user->id;
        $binnacle->bitc_fecha = date("Y-m-d H:i:s");
        $binnacle->bitcta_tipo_op = 'logout';
        $binnacle->bitcta_ip = $binnacle->getrealip();
        $browser_arr = $binnacle->getBrowser();
        $binnacle->bitcta_naveg = $browser_arr['name'].' '.$browser_arr['version'];
        $binnacle->bitc_modulo = '\Login';
        $binnacle->bitcta_result = 'TODO';
        $usr = User::find($event->user->id);

        $binnacle->bitcta_msg = 'Logout de usuario '.$usr->name;
        $usr->users_f_ultacces = date('Y-m-d H:i:s');
        $usr->save();
        $binnacle->bitcta_dato = json_encode($_REQUEST);
        $binnacle->save();

    }


    public function onUserLockout($event) {
        //Log::info($event->request);
        $email = $event->request['email'];
        $usr = User::where('email', '=', $email)->get();
        $binnacle = new Bitacora();
        $binnacle->bitcta_users_id = $usr[0]->id;
        $binnacle->bitc_fecha = date("Y-m-d H:i:s");
        $binnacle->bitcta_tipo_op = 'lockout';
        $binnacle->bitcta_ip = $binnacle->getrealip();
        $browser_arr = $binnacle->getBrowser();
        $binnacle->bitcta_naveg = $browser_arr['name'].' '.$browser_arr['version'];
        $binnacle->bitc_modulo = '\Login';
        $binnacle->bitcta_result = 'TODO';
        $usr = User::find($usr[0]->id);
        $usr->users_blocked = true;
        $usr->save();


        $binnacle->bitcta_msg = 'Bloqueo de usuario '.$usr->name.' por superar máxima cantidad de intentos fallidos de autenticación';
        $usr->users_f_ultacces = date('Y-m-d H:i:s');
        $usr->save();
        $binnacle->bitcta_dato = json_encode($_REQUEST);
        $binnacle->save();

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
            'Illuminate\Auth\Events\Failed',
            'App\Listeners\UserEventListener@onUserLoginFailed'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventListener@onUserLogout'
        );

        $events->listen(
            'Illuminate\Auth\Events\Lockout',
            'App\Listeners\UserEventListener@onUserLockout'
        );
    }

}    