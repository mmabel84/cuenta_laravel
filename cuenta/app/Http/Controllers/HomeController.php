<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Aplicacion;
use App\BasedatosApp;
use App\Paquete;
use App\User;
use App\Certificado;
Use View;
use SoapClient;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

//define("URL_WS_69", 'http://lista69.advans.mx/Lista69b/index/consultarLista.wsdl');

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_logued = Auth::user();
        Log::info('Usuario logueado '.$user_logued);
        $emps = Empresa::all();
        $appsall = Aplicacion::all();
        $appsact = $appsall->where('app_activa', '=', true);
        $appsdesact = $appsall->where('app_activa', '=', false);
        $appstest = $appsall->where('app_estado', '=', 'Prueba');
        $apps = $appsall->where('app_estado','!=','Prueba');
        $usrs = User::all();
        $bdapps = BasedatosApp::all();
        $bdappstest = 0;

        //Contando cantidad de instancias generadas por concepto de prueba
        foreach ($bdapps as $bd) {
            if ($bd->aplicacion->app_estado == 'Prueba')
            {
                $bdappstest+=1;
            }

        }

        //Cálculo de instancias contratadas y creadas por aplicación
        $appnames = [];
        $instcont = [];
        $instcreadas = [];
        $megcons = [];

        foreach ($appsall as $app) {
            array_push($appnames, $app->app_nom);
            if ($app->app_insts == null || $app->app_estado == 'Prueba')
                $app_inst = 0;
            else
                $app_inst = $app->app_insts;
            array_push($instcont, $app_inst);
            $cantinst = BasedatosApp::where('bdapp_app', '=', $app->app_cod)->get();
            array_push($instcreadas, count($cantinst));
            $megtemp = 0;
            foreach ($cantinst as $inst) {
                $megtemp += $inst->bdapp_gigcons;
            }
            array_push($megcons, $megtemp);



        }

        //diccionario con aplicaciones contratadas activas
        $url_fact = config('app.advans_apps_url.fact');
        $url_bov = config('app.advans_apps_url.bov');
        $url_cont = config('app.advans_apps_url.cont');
        $url_nom = config('app.advans_apps_url.nom');
        $url_pld = config('app.advans_apps_url.pld');
        $url_cc = config('app.advans_apps_url.cc');
        $url_not = config('app.advans_apps_url.not');

        $url_doc_fact = config('app.advans_apps_doc_url.fact');
        $url_doc_bov = config('app.advans_apps_doc_url.bov');
        $url_doc_cont = config('app.advans_apps_doc_url.cont');
        $url_doc_nom = config('app.advans_apps_doc_url.nom');
        $url_doc_pld = config('app.advans_apps_doc_url.pld');
        $url_doc_cc = config('app.advans_apps_doc_url.cc');
        $url_doc_not = config('app.advans_apps_doc_url.not');

        $appsicons = array (
                    'fact'=>"<a href='' data-dir='".$url_fact."' data-toggle='tooltip' data-placement='right' id='fact' target='_blank' class='disabled' title='Acceso a aplicación de facturación electrónica'><i class='iconfact icon-accessibilityfact' padding: 0 25px;'>
                    </i></a>",
                    'bov'=>"<a href='' data-dir='".$url_bov."' data-toggle='tooltip' data-placement='right' id='bov' target='_blank' class='disabled' title='Acceso a aplicación de bóveda'><i class='iconbov icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='' data-dir='".$url_cont."' data-toggle='tooltip' data-placement='right' id='cont' class='disabled' target='_blank' title='Acceso a aplicación de contabilidad'><i class='iconcont icon-accessibilitycont' padding: 0 25px;'>
                    </i></a>",
                     'nom'=>"<a href='#' data-dir='".$url_nom."' data-toggle='tooltip' data-placement='right' id='nom' class='disabled' target='_blank'><i class='fa fa-table fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='' data-dir='".$url_pld."' title='Acceso a aplicación de PLD' data-toggle='tooltip' data-placement='right' id='pld' class='disabled' target='_blank'><i class='iconpld icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='#' data-dir='".$url_not."' data-toggle='tooltip' data-placement='right' id='not' class='disabled' target='_blank'><i class='fa fa-bank fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='' data-dir='".$url_cc."' data-toggle='tooltip' data-placement='right' id='cc' class='disabled' target='_blank'><i class='fa fa-tasks fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>TAREAS</b></span></i></a>
                    ");

        //diccionario con aplicaciones en prueba activas

        $appsenprueba = array (
                    'fact'=>"<a href='' data-dir='".$url_fact."' data-toggle='tooltip' data-placement='right' id='fact' target='_blank' class='disabled' title='Acceso de prueba a aplicación de facturación electrónica'><i class='iconfacttest icon-accessibilityfact' padding: 0 25px;'>
                    </i></a>",
                    'bov'=>"<a href='' data-dir='".$url_bov."' data-toggle='tooltip' data-placement='right' id='bov' target='_blank' class='disabled' title='Acceso de prueba a aplicación de bóveda'><i class='iconbovtest icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='' data-dir='".$url_cont."' data-toggle='tooltip' data-placement='right' id='cont' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Contabilidad' ><i class='iconconttest icon-accessibilitycont' padding: 0 25px;'>
                    </i></a>",
                     'nom'=>"<a href='#' data-dir='".$url_nom."' data-toggle='tooltip' data-placement='right' id='nom' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Nómina' ><i class='fa fa-table fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='' data-dir='".$url_pld."' title='Acceso de prueba a aplicación de PLD' data-toggle='tooltip' data-placement='right' id='pld' class='disabled' target='_blank'><i class='iconpldtest icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='#' data-dir='".$url_not."' data-toggle='tooltip' data-placement='right' id='not' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Notaría' ><i class='fa fa-bank fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='' data-dir='".$url_cc."' data-toggle='tooltip' data-placement='right' id='cc' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Control de Calidad' ><i class='fa fa-tasks fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>TAREAS</b></span></i></a>
                    ");

        //diccionario de aplicaciones bloqueadas
        $appsiconsblocked = array (
                    'fact'=>"<a href='' data-dir='' class='disabledblocked' data-toggle='tooltip' data-placement='right' id='fact' title='Aplicación para facturación electrónica' target='_blank'><i class='iconfact icon-accessibilityfact' padding: 0 25px;'>
                    </i></a>",
                    'bov'=>"<a href='' data-dir='' data-toggle='tooltip' data-placement='right' id='bov' target='_blank' class='disabledblocked' title='Acceso a aplicación de bóveda'><i class='iconbov icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='' data-dir='' data-toggle='tooltip' data-placement='top' id='cont' class='disabledblocked' target='_blank'><i class='iconcont icon-accessibilitycont' padding: 0 25px;'>
                    </i></a>",
                     'nom'=>"<a href='' data-dir='' data-toggle='tooltip' data-placement='right' id='nom' class='disabledblocked' target='_blank'><i class='fa fa-table fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='' data-dir='' data-toggle='tooltip' data-placement='right' id='pld' class='disabledblocked' target='_blank'><i class='iconpld icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='' data-dir='' data-toggle='tooltip' data-placement='right' id='not' class='disabledblocked' target='_blank'><i class='fa fa-bank fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='' data-dir='' data-toggle='tooltip' data-placement='right' id='cc' class='disabledblocked' target='_blank'><i class='fa fa-tasks fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>TAREAS</b></span></i></a>
                    ");

        //diccionario de aplicaciones no contratadas
        $appdisp = array (
                    'fact'=>"<a href='".$url_doc_fact."' data-toggle='tooltip' data-placement='right' id='factd' title='Aplicación para facturación electrónica' target='_blank'><i class='iconfact icon-accessibilityfact' padding: 0 25px;'></i></a>",

                    'bov'=>"<a href='".$url_doc_bov."' data-toggle='tooltip' data-placement='right' id='bovd' target='_blank' title='Aplicación de bóveda'><i class='iconbov icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='".$url_doc_cont."' data-toggle='tooltip' data-placement='right' id='contd' title='Aplicación para la contabilidad interna de la empresa' target='_blank'><i class='fa fa-briefcase fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>CONTAB</b></span></i></a>",
                     'nom'=>"<a href='".$url_doc_nom."' data-toggle='tooltip' data-placement='right' id='nomd' title='Aplicación para el cálculo de la nómina' target='_blank'><i class='fa fa-table fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='".$url_doc_pld."' data-toggle='tooltip' data-placement='right' id='pldd' title='Mejpra PLD para la prevención de lavado de dinero' target='_blank'><i class='iconpld icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='".$url_doc_not."' data-toggle='tooltip' data-placement='right' id='notd' title='Aplicación para el manejo de notarías' target='_blank'><i class='fa fa-bank fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='".$url_doc_cc."' data-toggle='tooltip' data-placement='right' id='ccd' title='Aplicación para el seguimiento de tareas' target='_blank'><i class='fa fa-tasks fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>TAREAS</b></span></i></a>
                    ");

        
        //Ubicando aplicaciones según secciones de panel donde deben mostrarse
        $allkeys = array_keys($appsicons);
        $appdispvisible = '';
        
        $appvisible = '';
        $asignadas = '';

        foreach ($allkeys as $key) {
             $app = Aplicacion::where('app_cod', '=', $key)->get();
             
            if (count($app)>0){
                if ($app[0]->app_activa == true){
                    if ($app[0]->app_estado != 'Prueba')
                    {
                        $appvisible = $appvisible.$appsicons[$key];
                    }
                    else
                    {
                        $appvisible = $appvisible.$appsenprueba[$key];
                    }
                    
                }
                else{
                    $appvisible = $appvisible.$appsiconsblocked[$key];
                }

             }
             else{
                $appdispvisible = $appdispvisible.$appdisp[$key];
             }
        }

        //Calculando cantidad de aplicaciones con instancias creadas y cantidad de megas asignados total
        $cantgigas = 0;
        $cant_app_coninst = 0;
        $cantinstcont = 0; 
        $cantgigasign = 0;
        $cantgigastest = 0;
        $cantgigasigntest = 0;
        $cant_gigas_rest_test = 0;

        

       foreach ($apps as $app) {
           $cantgigas = $cantgigas + $app->app_megs;
            $cantinstcont = $cantinstcont + $app->app_insts;
            $cant_inst = BasedatosApp::where('bdapp_app_id', '=', $app->id)->get();
            if (count($cant_inst) > 0)
            {
                $cant_app_coninst += 1;
                foreach ($cant_inst as $inst) {
                    $cantgigasign = $cantgigasign + $inst->bdapp_gigdisp;
                }
            }
       }

       foreach ($appstest as $appt) {
           $cantgigastest = $cantgigastest + $appt->app_megs;
           $cant_inst_test = BasedatosApp::where('bdapp_app_id', '=', $appt->id)->get();
           if (count($cant_inst_test) > 0)
            {
                foreach ($cant_inst_test as $instt) {
                    $cantgigasigntest = $cantgigasigntest + $instt->bdapp_gigdisp;
                }
            }
       }

       $cant_gigas_rest_test = $cantgigastest - $cantgigasigntest;
       $cant_gigas_rest = $cantgigas - $cantgigasign;

       

       //Calculando porcentaje de tiempo consumido
        $fecha_venta = '';
        $fecha_fin = '';
        $fecha_caduc = '';
        $porc_fin = 0;
        $intervalshow = 0;
        $medida_tiempo = 'SIN LÍNEA DE TIEMPO ACTIVA';
        $color_interval = '#FFFFFF';


        $paquetes = Paquete::where('paqapp_activo', '=', true)->get();

        if (count($paquetes) > 0)
        {
            $fecha_venta = $paquetes[0]->paqapp_f_venta;
            $fecha_fin = $paquetes[0]->paqapp_f_fin;
            $fecha_caduc = $paquetes[0]->paqapp_f_caduc;

            $fecha_actual = strtotime("now");
            $dias_total_fin = strtotime($fecha_fin) - strtotime($fecha_venta);
            $dias_transc_fin = $fecha_actual - strtotime($fecha_venta);
            $dias_hasta_fin = strtotime($fecha_fin) - $fecha_actual;


            if ($fecha_actual < strtotime($fecha_venta))
            {
                $porc_fin = 0;
            }
            elseif ($dias_total_fin > 0) {
                $porc_fin = round($dias_transc_fin / $dias_total_fin * 100, 0);
            }
            else
            {
                $porc_fin = 100;
            }
            
            //Calculando semanas disponibles o de atraso
           
            foreach ($paquetes as $p) {

                if ($fecha_venta > $p->paqapp_f_venta){
                     $fecha_venta = $p->paqapp_f_venta;
                }
                if ($fecha_fin < $p->paqapp_f_fin){
                    $fecha_fin = $p->paqapp_f_fin;
                }
                if ($fecha_caduc < $p->fecha_caduc){
                    $fecha_caduc = $p->fecha_caduc;
                }
            }

            $medida_tiempo = '';
            $fecha_fin_datetime = new Datetime($fecha_fin);
            $fecha_actual_datetime = new Datetime(date('Y-m-d H:i:s'));
            $interval=$fecha_fin_datetime->diff($fecha_actual_datetime);
            $intervalsemanas=round($interval->format("%a") / 7, 0);
            $intervaldias=round($interval->format("%d"));
            $intervalAnos = round($interval->format("%y")*12, 0);
            $intervalshow = $intervalsemanas;
            $color_interval = '#053666';

            if ($paquetes[0]->paqapp_pagado == false)
            {
                if ($dias_hasta_fin >= 0)
                {
                    if ($intervalsemanas > 1)
                    {
                        $medida_tiempo = 'SEMANAS DISPONIBLES PARA PAGO';
                    }
                    elseif ($intervalsemanas == 1)
                    {
                        $medida_tiempo = 'SEMANA DISPONIBLE PARA PAGO';
                        $color_interval = '#b38f00';
                    }
                    else
                    {   
                        $color_interval = '#990000';
                        $intervalshow = $intervaldias;
                        if ($intervaldias > 1){
                            $medida_tiempo = 'DÍAS DISPONIBLES PARA PAGO';
                        }
                        else{
                            $medida_tiempo = 'DÍA DISPONIBLE PARA PAGO';
                        }
                    }
                }
                else
                {
                    $color_interval = '#990000';
                    $intervalshow = $intervaldias;
                    if ($intervaldias > 1){
                        $medida_tiempo = 'DÍAS DE ATRASO PARA PAGO';
                    }
                    else{
                        $medida_tiempo = 'DÍA DE ATRASO PARA PAGO';
                    }
                }
            }
            else
            {
                $medida_tiempo = 'LÍNEA DE TIEMPO PAGADA';
                $color_interval = '#FFFFFF';
            }
        }


        //Calculando gigas consumidos por empresa
        $cant_gigas_cons = 0;
        $dict_empr_gig = array();
        $gigas_cons_emp = array();
        $empr_cons = array();

        
        foreach ($bdapps as $a) {
            if ($a->bdapp_gigcons != null){

                $cant_gigas_cons+=$a->bdapp_gigcons;

                if (array_key_exists($a->empresa->empr_nom, $dict_empr_gig)){
                    $dict_empr_gig[$a->empresa->empr_nom] += $a->bdapp_gigcons;
                } else{
                    $dict_empr_gig[$a->empresa->empr_nom] =  $a->bdapp_gigcons;
                    
                }

            }
            $empr_cons = array_keys($dict_empr_gig);
            $gigas_cons_emp = array_values($dict_empr_gig);
        }

        
        $porc_esp_cons = 0;
        if ($cantgigas > 0)
        {
            $porc_esp_cons = round(($cant_gigas_cons / $cantgigas) * 100, 2);
        }

        

        $medidaespdisp = 'megas';
        if ($cantgigas >= 1024)
        {
            $cantgigas = round($cantgigas / 1024, 2);
            $medidaespdisp = 'gigas';
        }

        $medidaesprest = 'megas';
        if ($cant_gigas_cons >= 1024)
        {
            $cant_gigas_cons = round($cant_gigas_cons / 1024, 2);
            $medidaesprest = 'gigas';

        }



        //Calculando vigencia de certificados
        $certificados = Certificado::all();
        $certificados = $certificados->sortByDesc('cert_f_fin');
        $cert_vencidos = Certificado::where('cert_f_fin', '<', date('Y-m-d H:i:s'))->get();

        $main_empr = Empresa::where('empr_principal', '=', true)->get();
        $fecha_actual = new Datetime(date('Y-m-d H:i:s')); 
        $htmlcert = '';
        foreach ($certificados as $certf) {
            $fecha_fin_cert = new DateTime($certf->cert_f_fin);
            $dias_vigencia = $fecha_actual->diff($fecha_fin_cert)->format("%r%a");

            if ($dias_vigencia >= 0 /*&& $dias_vigencia <= 45*/)
            {
                $horas_vigencia = date_diff($fecha_actual,$fecha_fin_cert)->format('%h:%i:%s');

                $msgvenc = 'Vence en '.$dias_vigencia.' días';
                $title = $fecha_fin_cert->format('Y-m-d H:i:s');
                $class = "success";
                if ($dias_vigencia >= 15 && $dias_vigencia < 30)
                        $class = "warning";
                 if ($dias_vigencia < 15)
                        $class = "danger";
                if ($dias_vigencia == 1)
                        $msgvenc = 'Vence mañana';
                if ($dias_vigencia == 0) {
                        $msgvenc = 'Vence hoy';
                        list($h, $m, $s) = explode(":", $horas_vigencia);
                        $title = implode(' ', array("Vence en", ($h > 0 ? intval($h) . ' hora' . ($h > 1 ? 's' : '') : '' ), ($m > 0 ? intval($m) . ' minuto' . ($m > 1 ? 's' : '') : ''), intval($s) . " segundo" . ($s > 1 ? 's' : '')));
                    }
                /*if ($dias_vigencia == -1)
                        $msgvenc = 'Venció ayer';
                if ($dias_vigencia < -1)
                        $msgvenc = 'Venció hace ' . abs($dias_vigencia) . " días";*/

                $htmlcert .='<span style="font-size:11px" class="badge progress-bar-' . $class . ' badge" title="' .$msgvenc .', '. $title . '" >'. $certf->cert_rfc .'/'. $certf->cert_tipo.'</span>'
                            .'<br></br>';

            }
        }

        //recuperando noticias de servicio web de control

        $arrayparams = [];
        $noticias = [];
        $service_response = [];
        $acces_vars = $this->getAccessToken();
        
        try
        {
            $service_response = $this->getAppService($acces_vars['access_token'],'getnews',$arrayparams,'control');
            if (count($service_response['news']) > 0){
                $noticias = json_decode($service_response['news']);
            }
        } 
        catch (\GuzzleHttp\Exception\ServerException $e) 
        {
             \Session::put('newserror', 'Sin comunicación a servicio de control para noticias');
        }

        //recuperando fecha de actualización de artículo 69
         $fecha_act_69 = '';
         try
        {
            $service_response = $this->getAppService($acces_vars['access_token'],'getmax69',$arrayparams,'control');
            if (count($service_response['response69']) > 0){
                $fecha_act_69 = $service_response['response69'][0]['fecha'];
                //Log::info($fecha_act_69[0]['fecha']);
            }
        } 
        catch (\GuzzleHttp\Exception\ServerException $e) 
        {
             \Session::put('newserror', 'Sin comunicación a servicio de control para noticias');
        }

        //Tomando número de cuenta
        $empresaprincipal = Empresa::where('empr_principal', '=', true)->get();
        $num_cta = '';
        if (count($empresaprincipal) > 0)
        {
            $num_cta = $empresaprincipal[0]->empr_rfc;
        }

        

        return view('panel',['emps'=>json_encode($emps),'appvisible'=>$appvisible, 'appdispvisible'=>$appdispvisible,'insts'=>$cantinstcont,'gigas'=>$cantgigas,'rfccreados'=>count($emps), 'cantinstcreadas'=>count($bdapps),'apps'=>count($apps),'appsact'=>count($appsact), 'cant_app_coninst'=>$cant_app_coninst,'usrs'=>count($usrs),'porc_final'=>$porc_fin,'fecha_fin'=>$fecha_fin,'fecha_caduc'=>$fecha_caduc,'gigas_cons'=>$cant_gigas_cons,'gigas_empresa'=>json_encode($gigas_cons_emp),'empr_cons'=>json_encode($empr_cons), 'intervalshow'=>$intervalshow, 'medida_tiempo'=>$medida_tiempo, 'htmlcert'=>$htmlcert, 'cant_cert_vencidos'=>count($cert_vencidos), 'cant_cert'=>count($certificados), 'noticias'=>$noticias, 'noticiasstr'=>json_encode($noticias), 'appnames'=>json_encode($appnames),'instcont'=>json_encode($instcont), 'instcreadas'=>json_encode($instcreadas), 'megcons'=>json_encode($megcons),'appsall'=>count($appsall), 'appstest'=>count($appstest), 'appsdesact'=>count($appsdesact), 'color_interval'=>$color_interval, 'cantbdappstest'=>$bdappstest,'medidaespdispmay'=>strtoupper($medidaespdisp),'cant_gigas_rest'=>$cant_gigas_rest,'porc_esp_cons'=>$porc_esp_cons,'medidaesprest'=>$medidaesprest,'fecha_act_69'=>$fecha_act_69,'num_cta'=>$num_cta,'pass_change'=>$user_logued->password_change,'cantgigasign'=>$cantgigasign,'cantgigastest'=>$cantgigastest,'cantgigasigntest'=>$cantgigasigntest,'cant_gigas_rest_test'=>$cant_gigas_rest_test]);

    }

    public function appbyemp(Request $request)
    {
        $alldata = $request->all();
        $return_array = array();
       
        
        if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){
            $emprfc = $alldata['selected'];
            $emp = Empresa::where('empr_rfc', '=', $emprfc)->get();
            Log::info($emp);
            $bdapps = [];

            if (count($emp) > 0){
                $bdapps = BasedatosApp::where('bdapp_empr_id', '=', $emp[0]->id)->get();

            }
            if(count($bdapps)){
                foreach ($bdapps as $bdapp) {
                    $code = $bdapp->bdapp_app;
                    array_push($return_array, $code);
                }
            }
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'appcodes' => $return_array,
        );

        return \Response::json($response);
    }

    function auditar69b(Request $request) {
        $rfc = strtoupper($request->rfc);
        $data['error'] = 1;
        $data['reporte'] = 0;
        $arrayparams = array();
        $arrayparams['by_rfc'] = true;
        $arrayparams['rfc_value'] = $rfc;
        $reporte = [];
        try
        {
            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'get69response',$arrayparams,'control');
            
            if (count($service_response['response69']) > 0){
                $registros69 = $service_response['response69'];
                

                foreach ($registros69 as $r) {
                    if ($r['tipo'] == 'Presunto'){
                        $reporte['69'] = [];
                       array_push($reporte['69'], $r);
                    }
                    elseif ($r['tipo'] == 'Definitivo')
                    {
                        $reporte['69b'] = [];
                        array_push($reporte['69b'], $r);
                    }
                    else
                    {
                        $reporte['desvirtuados'] = [];
                        array_push($reporte['desvirtuados'], $r);
                    }
                }
            }
           $response = $this->_reporteA69($reporte,$rfc);
            $data['reporte'] = $response['htmldef'];
            $data['tienerep'] = $response['tienerep'];

        } 
        catch (\GuzzleHttp\Exception\ServerException $e) 
        {
             \Session::put('newserror', 'Sin comunicación a servicio de control para consulta de artículo 69');
        }
        return \Response::json($data);

    }


    function _reporteA69($json69,$rfc){
        //array key probables: \(°-°)/
        //69b
        //69
        //desvirtuados

        //preparando el html
        $html = '';
        $tienerep = false;

        $html .= '<dl class="dl-horizontal">';

        //verificando si es un array
        if(count($json69) > 0){

                //buscando el array key 69b
                if(array_key_exists('69b',$json69)){
                    $tienerep = true;
                       $html .= '
                        <dt>Encontrado en:</dt>
                            <dd>Lista 69 - B definitivos</dd>
                        <br>
                        <ul class="list-group">';
                       //recorremos los datos de la respuesta
                       for ($i=0; $i < count($json69['69b']); $i++) {
                            $html .='
                            <li class="list-group-item list-group-item-danger">
                                #'.$json69['69b'][$i]['id'].'<br>
                                Empresa: '.$json69['69b'][$i]['contribuyente'].'<br>
                                Número de oficio: '.$json69['69b'][$i]['oficio'].'<br>
                                Fecha de SAT: '.$json69['69b'][$i]['fecha_sat'].'<br>
                                Fecha de DOF: '.$json69['69b'][$i]['fecha_dof'].'<br>
                                Acceso a oficio: <a target="_blank" href="'.$json69['69b'][$i]['url_oficio'].'">Ver oficio.pdf</a><br>
                                Acceso a anexo: <a target="_blank" href="'.$json69['69b'][$i]['url_anexo'].'">Ver anexo.pdf</a><br>
                            </li><br>';
                        }
                        $html.='</ul>';
                }
                //buscando el array key 69
                if(array_key_exists('69',$json69)){
                    $tienerep = true;
                        $html .= '
                        <dt>Encontrado en:</dt>
                            <dd>Lista 69 presuntos</dd>
                        <br>
                        <ul class="list-group">';
                        //recorremos los datos de la respuesta
                       for ($i=0; $i < count($json69['69']); $i++) {
                            $html .='
                            <li class="list-group-item list-group-item-warning">
                                #'.$json69['69'][$i]['id'].'<br>
                                Empresa: '.$json69['69'][$i]['contribuyente'].'<br>
                                Número de oficio: '.$json69['69'][$i]['oficio'].'<br>
                                Fecha de SAT: '.$json69['69'][$i]['fecha_sat'].'<br>
                                Fecha de DOF: '.$json69['69'][$i]['fecha_dof'].'<br>
                                Acceso a oficio: <a target="_blank" href="'.$json69['69'][$i]['url_oficio'].'">Ver oficio.pdf</a><br>
                               Acceso a anexo: <a target="_blank" href="'.$json69['69'][$i]['url_anexo'].'">Ver anexo.pdf</a><br>
                            </li><br>';
                        }
                        $html.='</ul>';

                }
                //buscando el array key desvirtuados
                if(array_key_exists('desvirtuados',$json69)){
                    $tienerep = true;

                        $html .= '
                        <dt>Encontrado en:</dt>
                            <dd>Desvirtuados</dd>
                        <br>
                        <ul class="list-group">';
                        //recorremos los datos de la respuesta
                       for ($i=0; $i < count($json69['desvirtuados']); $i++) {
                            $html .='
                            <li class="list-group-item list-group-item-success">
                                #'.$json69['desvirtuados'][$i]['id'].'<br>
                                Empresa: '.$json69['desvirtuados'][$i]['contribuyente'].'<br>
                                Número de oficio: '.$json69['desvirtuados'][$i]['oficio'].'<br>
                                Fecha de SAT: '.$json69['desvirtuados'][$i]['fecha_sat'].'<br>
                                Fecha de DOF: '.$json69['desvirtuados'][$i]['fecha_dof'].'<br>
                                Acceso a oficio: <a target="_blank" href="'.$json69['desvirtuados'][$i]['url_oficio'].'">Ver oficio.pdf</a><br>
                                Acceso a anexo: <a target="_blank" href="'.$json69['desvirtuados'][$i]['url_anexo'].'">Ver anexo.pdf</a><br>
                            </li><br>';
                        }
                        $html.='</ul>';
                }

        }else
        {
            //si no se encontro nada
            $htmlsinreporte = '
                              <div>
                                <label style="color: #3DB1A5" id="norep">No se encontró incidencia</label>
                              </div>';

        }
        $html .='</dl>';

        $htmldef = '';      
        if ($tienerep == true){
            $htmldef = $html;
        }
        else{
            $htmldef = $htmlsinreporte;
        }

        return  array('htmldef' => $htmldef, 'tienerep'=> $tienerep);
    }


    function redirectapp($numcta,$rfc,$codapp)
    {
        $url_app = config('app.advans_apps_url.'.$codapp);
        $dbname = $numcta.'_'.$rfc.'_'.$codapp;
        $user = \Auth::user()
        $user_id = $user->id;
        $bdapp = BasedatosApp::where('bdapp_nombd', '=', $dbname)->get()
        $bdapp_id = 0;
        if (count($bdapp) > 0)
        {
            $bdapp_id = $bdapp[0]->id;
        }

        $exists = $user->basedatosapps->contains($bdapp_id);


        if ($codapp != 'fact')
        {
            $acces_vars = $this->getAccessToken($codapp);
            $arrayparams['dbname']=$dbname;
            $arrayparams['rfc']=$rfc;
            $arrayparams['cta']=$numcta;
            $arrayparams['cod']=$codapp;
            $arrayparams['id_usuario']=$user_id;
            $service_response = $this->getAppService($acces_vars['access_token'],'loginservice',$arrayparams,$codapp);
            if(array_key_exists('msg', $service_response))
            {
                $url_final = $url_app.'/msl/'.$arrayparams['dbname'].'/'.$service_response['msg'];
            }
            else
            {
                if (!$exists)
                {
                    $url_final = $url_app.'/logout'
                }
                else
                {
                    $url_final = $url_app.$rfc;
                }
            }
            
            return response()->redirectTo($url_final);
        }
        else
        {
            $url_final = $url_app.$rfc;
            return response()->redirectTo($url_final);
        }
    }


    
}
