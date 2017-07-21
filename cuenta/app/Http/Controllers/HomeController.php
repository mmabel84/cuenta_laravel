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

        $appsicons = array (
                    'fact'=>"<a href='' data-dir='https://app.advans.mx/' data-toggle='tooltip' data-placement='right' id='fact' target='_blank' class='disabled' title='Acceso a aplicación de facturación electrónica'><i class='iconfact icon-accessibilityfact' padding: 0 25px;'>
                    </i></a>",
                    'bov'=>"<a href='' data-dir='http://lab1.advans.mx/control/login#' data-toggle='tooltip' data-placement='right' id='bov' target='_blank' class='disabled' title='Acceso a aplicación de bóveda'><i class='iconbov icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='' data-dir='http://lab1.advans.mx/control/login/' data-toggle='tooltip' data-placement='top' id='cont' class='disabled' target='_blank'><i class='fa fa-briefcase fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>CONTAB</b></span></i></a>",
                     'nom'=>"<a href='#' data-dir='#' data-toggle='tooltip' data-placement='right' id='nom' class='disabled' target='_blank'><i class='fa fa-table fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='' data-dir='http://pld-beta.advans.mx/app/usuarios/login#' title='Acceso a aplicación de PLD' data-toggle='tooltip' data-placement='right' id='pld' class='disabled' target='_blank'><i class='iconpld icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='#' data-dir='#' data-toggle='tooltip' data-placement='right' id='not' class='disabled' target='_blank'><i class='fa fa-bank fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='' data-dir='http://ecacc.selfip.org/cc_beta/index.php/usuarios/login' data-toggle='tooltip' data-placement='right' id='cc' class='disabled' target='_blank'><i class='fa fa-tasks fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>TAREAS</b></span></i></a>
                    ");

        //diccionario con aplicaciones en prueba activas

        $appsenprueba = array (
                    'fact'=>"<a href='' data-dir='https://app.advans.mx/' data-toggle='tooltip' data-placement='right' id='fact' target='_blank' class='disabled' title='Acceso de prueba a aplicación de facturación electrónica'><i class='iconfacttest icon-accessibilityfact' padding: 0 25px;'>
                    </i></a>",
                    'bov'=>"<a href='' data-dir='http://lab1.advans.mx/control/login#' data-toggle='tooltip' data-placement='right' id='bov' target='_blank' class='disabled' title='Acceso de prueba a aplicación de bóveda'><i class='iconbovtest icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='' data-dir='http://lab1.advans.mx/control/login/' data-toggle='tooltip' data-placement='top' id='cont' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Contabilidad' ><i class='fa fa-briefcase fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>CONTAB</b></span></i></a>",
                     'nom'=>"<a href='#' data-dir='#' data-toggle='tooltip' data-placement='right' id='nom' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Nómina' ><i class='fa fa-table fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='' data-dir='http://pld-beta.advans.mx/app/usuarios/login#' title='Acceso de prueba a aplicación de PLD' data-toggle='tooltip' data-placement='right' id='pld' class='disabled' target='_blank'><i class='iconpldtest icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='#' data-dir='#' data-toggle='tooltip' data-placement='right' id='not' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Notaría' ><i class='fa fa-bank fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='' data-dir='http://ecacc.selfip.org/cc_beta/index.php/usuarios/login' data-toggle='tooltip' data-placement='right' id='cc' class='disabled' target='_blank' title='Acceso de prueba a aplicación de Control de Calidad' ><i class='fa fa-tasks fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>TAREAS</b></span></i></a>
                    ");

        //diccionario de aplicaciones bloqueadas
        $appsiconsblocked = array (
                    'fact'=>"<a href='https://app.advans.mx/login/usuarios/login' class='disabledblocked' data-toggle='tooltip' data-placement='right' id='factd' title='Aplicación para facturación electrónica' target='_blank'><i class='iconfact icon-accessibilityfact' padding: 0 25px;'>
                    </i></a>",
                    'bov'=>"<a href='' data-dir='http://lab1.advans.mx/control/login/' data-toggle='tooltip' data-placement='right' id='bov' target='_blank' class='disabledblocked' title='Acceso a aplicación de bóveda'><i class='iconbov icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='http://lab1.advans.mx/control/login/' data-toggle='tooltip' data-placement='top' id='cont' class='disabledblocked' target='_blank'><i class='fa fa-briefcase fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>CONTAB</b></span></i></a>",
                     'nom'=>"<a href='#' data-toggle='tooltip' data-placement='right' id='nom' class='disabledblocked' target='_blank'><i class='fa fa-table fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='#' data-toggle='tooltip' data-placement='right' id='pld' class='disabledblocked' target='_blank'><i class='iconpld icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='#' data-toggle='tooltip' data-placement='right' id='not' class='disabledblocked' target='_blank'><i class='fa fa-bank fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='http://ecacc.selfip.org/cc_beta/index.php/usuarios/login' data-toggle='tooltip' data-placement='right' id='cc' class='disabledblocked' target='_blank'><i class='fa fa-tasks fa-4x' style='color:#053666; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>TAREAS</b></span></i></a>
                    ");

        //diccionario de aplicaciones no contratadas
        $appdisp = array (
                    'fact'=>"<a href='http://www.advans.mx/content/factura-electronica-advans' data-toggle='tooltip' data-placement='right' id='factd' title='Aplicación para facturación electrónica' target='_blank'><i class='iconfact icon-accessibilityfact' padding: 0 25px;'></i></a>",

                    'bov'=>"<a href='http://www.advans.mx/content/validacion-cfdi-advans' data-toggle='tooltip' data-placement='right' id='bovd' target='_blank' title='Aplicación de bóveda'><i class='iconbov icon-accessibilitybov' padding: 0 25px;'>
                    </i></a>",
                    'cont'=>"<a href='http://www.advans.mx/content/sobre-advans' data-toggle='tooltip' data-placement='right' id='contd' title='Aplicación para la contabilidad interna de la empresa' target='_blank'><i class='fa fa-briefcase fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>CONTAB</b></span></i></a>",
                     'nom'=>"<a href='http://www.advans.mx/content/sobre-advans' data-toggle='tooltip' data-placement='right' id='nomd' title='Aplicación para el cálculo de la nómina' target='_blank'><i class='fa fa-table fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NÓMINA</b></span></i></a>",
                    'pld'=>"<a href='http://mejorapld.mx/software/' data-toggle='tooltip' data-placement='right' id='pldd' title='Mejpra PLD para la prevención de lavado de dinero' target='_blank'><i class='iconpld icon-accessibility' padding: 0 25px;'>
                    </i></a>",
                    
                    'not'=>"<a href='http://www.advans.mx/content/sobre-advans' data-toggle='tooltip' data-placement='right' id='notd' title='Aplicación para el manejo de notarías' target='_blank'><i class='fa fa-bank fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
                    <b>NOTARÍA</b></span></i></a>",
                    'cc'=>"<a href='http://www.advans.mx/content/sobre-advans' data-toggle='tooltip' data-placement='right' id='ccd' title='Aplicación para el seguimiento de tareas' target='_blank'><i class='fa fa-tasks fa-4x' style='color:#5c154d; padding: 0 25px;'><span style='display:block; font-size:12px; margin-top: 5px; text-align: center, margin: 0 auto;'>
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

        //Calculando cantidad de aplicaciones con instancias creadas
        $cantgigas = 0;
        $cant_app_coninst = 0;
        $cantinstcont = 0; 
       foreach ($apps as $app) {
           $cantgigas = $cantgigas + $app->app_megs;
            $cantinstcont = $cantinstcont + $app->app_insts;
            $cant_inst = BasedatosApp::where('bdapp_app_id', '=', $app->id)->get();
            if (count($cant_inst) > 0)
            {
                $cant_app_coninst += 1;
            }
       }

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

        
        return view('panel',['emps'=>json_encode($emps),'appvisible'=>$appvisible, 'appdispvisible'=>$appdispvisible,'insts'=>$cantinstcont,'gigas'=>$cantgigas,'rfccreados'=>count($emps), 'cantinstcreadas'=>count($bdapps),'apps'=>count($apps),'appsact'=>count($appsact), 'cant_app_coninst'=>$cant_app_coninst,'usrs'=>count($usrs),'porc_final'=>$porc_fin,'fecha_fin'=>$fecha_fin,'fecha_caduc'=>$fecha_caduc,'gigas_cons'=>$cant_gigas_cons,'gigas_empresa'=>json_encode($gigas_cons_emp),'empr_cons'=>json_encode($empr_cons), 'intervalshow'=>$intervalshow, 'medida_tiempo'=>$medida_tiempo, 'htmlcert'=>$htmlcert, 'cant_cert_vencidos'=>count($cert_vencidos), 'cant_cert'=>count($certificados), 'noticias'=>$noticias, 'noticiasstr'=>json_encode($noticias), 'appnames'=>json_encode($appnames),'instcont'=>json_encode($instcont), 'instcreadas'=>json_encode($instcreadas), 'megcons'=>json_encode($megcons),'appsall'=>count($appsall), 'appstest'=>count($appstest), 'appsdesact'=>count($appsdesact), 'color_interval'=>$color_interval, 'cantbdappstest'=>$bdappstest]);

    }

    public function appbyemp(Request $request)
    {
        $alldata = $request->all();
        $return_array = array();
       
        
        if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){
            $emprfc = $alldata['selected'];
            $emp = Empresa::where('empr_rfc', '=', $emprfc)->get();
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
        //recibe el rfc en post
        //$rfc = $this->input->post('rfc', TRUE);
        $rfc = $request->rfc;
        $data['error'] = 1;
        $data['reporte'] = 0;

            //inicializando el cliente (_*-*)_
       
        $cliente = new SoapClient('http://lista69.advans.mx/Lista69b/index/consultarLista?wsdl');//WEB_SERVICE_69 url del webserice definido en constans de Laravel

            
            //base64 el rfc antes de enviar
            $rfc64 = base64_encode($rfc);
            //preparando parametros, en este caso solo uno
            $params = array($rfc64);
            //llamamos el metodo declarodo en el servidor SOAP
            $result = $cliente->__soapCall("consultarLista", $params);
            //convertimos ajson la respuesta y luego a un array
            $json = json_decode($result, true);
            //verificamos que sea array


           if(is_array($json)){
                //verificamos que esxista el indice de error
                if(in_array('error',$json)){
                    //verificamos que no hay errores y que el reporte regreso algo
                    if($json['error']==0){
                        //preparamos el reporte para retornar
                        $response = $this->_reporteA69($json['reporte'],$rfc);
                        $data['reporte'] = $response['htmldef'];
                        $data['tienerep'] = $response['tienerep'];
                    }

                }
                //notificamos que se realizo el proceso sin errores
                $data['error'] = 0;
            }
        //retornamos la respuesta del servidor SOAP _(*-*_)
        //echo json_encode($data);

            //$data =  array('reporte' => 'helloooo');
        return \Response::json($data);
            //return  $data;

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

        /*$html .= '<div class="bootbox-body">
            <dl class="dl-horizontal">
                <dt>RFC:</dt>
                    <dd>'.$rfc.'</dd>
            ';*/
        //verificamos que no regreasar numerico

        if(!is_numeric($json69)){
            //verificando si es un array
            if(is_array($json69)){

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
                                    #'.$json69['69b'][$i]['iddefinitivos_69b'].'<br>
                                    Empresa: '.$json69['69b'][$i]['nombre_empresa_definitivos_69b'].'<br>
                                    Fecha de oficio: '.$json69['69b'][$i]['fecha_oficio_definitivos_69b'].'<br>
                                    Numero de oficio: '.$json69['69b'][$i]['numero_oficio_definitivos_69b'].'<br>
                                    Oficio: <a target="_blank" href="'.$json69['69b'][$i]['url_definitivos_69b'].'">Ver oficio.pdf</a><br>
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
                                    #'.$json69['69'][$i]['idpresuncion_69'].'<br>
                                    Empresa: '.$json69['69'][$i]['nombre_empresa_presuncion_69'].'<br>
                                    Fecha de oficio: '.$json69['69'][$i]['fecha_oficio_presuncion_69'].'<br>
                                    Presuncion: '.$json69['69'][$i]['tipo_presuncion'].'<br>
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
                                    #'.$json69['desvirtuados'][$i]['iddesvirtuados'].'<br>
                                    Empresa: '.$json69['desvirtuados'][$i]['nombre_empresa_desvirtuados'].'<br>
                                    Desvirtuado: '.$json69['desvirtuados'][$i]['tipo_desvirtuados'].'<br>
                                    Oficio: '.$json69['desvirtuados'][$i]['numero_fecha_oficio_desvirtuados'].'<br>
                                </li><br>';
                            }
                            $html.='</ul>';
                    }



            }
        }else{
            //si no se encontro nada

            $htmlsinreporte = '
                              <div>
                                <label style="color: #3DB1A5" id="norep">No se encontró incidencia</label>
                              </div>';
            
            /*$html .= '<br>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-success">
                                <span class="badge alert-success">
                                    <i class="glyphicon glyphicon-ok"></i>
                                </span>No se encontraron reportes del RFC proporcionado.
                            </li>
                        </ul>';*/
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
    
}
