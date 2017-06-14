<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Aplicacion;
use App\BasedatosApp;
use App\Paquete;
use App\User;
Use View;

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
        $apps = Aplicacion::all();
        $usrs = User::all();
        $bdapps = BasedatosApp::all();


        $appsicons = array ('pld'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='PLD' id='pld' class='disabled'><i class='fa fa-money fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'cont'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Contabilidad' id='cont' class='disabled'><i class='fa fa-bank fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'bov'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Bóveda' id='bov' class='disabled'><i class='fa fa-archive fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'not'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Notaría' id='not' class='disabled'><i class='fa fa-briefcase fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'cc'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Control de calidad' id='cc' class='disabled'><i class='fa fa-tasks fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'nom'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Nómina' id='nom' class='disabled'><i class='fa fa-table fa-3x' style='color:#053666;'></i></a>");

        $allkeys = array_keys($appsicons);
        
        $appvisible = '';
        $asignadas = '';

        foreach ($allkeys as $key) {
             $app = Aplicacion::where('app_cod', '=', $key)->get();
             if (count($app)>0){
                $appvisible = $appvisible.$appsicons[$key];
             }
        }

        $paquetes = Paquete::where('paqapp_activo', '=', true)->get();
        $cantgigas = 0;
        $cantrfc = 0;
        $fecha_act = '';
        $fecha_fin = '';
        $fecha_caduc = '';

        if (count($paquetes) > 0){
            $fecha_act = $paquetes[0]->paqapp_f_act;
            $fecha_fin = $paquetes[0]->paqapp_f_fin;
            $fecha_caduc = $paquetes[0]->paqapp_f_caduc;
        }
       
        foreach ($paquetes as $p) {
            $cantgigas = $cantgigas + $p->paqapp_cantgig;
            $cantrfc = $cantrfc + $p->paqapp_cantrfc;
            if ($fecha_act > $p->paqapp_f_act){
                 $fecha_act = $p->paqapp_f_act;
            }
            if ($fecha_fin < $p->paqapp_f_fin){
                $fecha_fin = $p->paqapp_f_fin;
            }
            if ($fecha_caduc < $p->fecha_caduc){
                $fecha_caduc = $p->fecha_caduc;
            }
        }
        $fecha_actual = strtotime("now");

        $dias_total_fin = strtotime($fecha_fin) - strtotime($fecha_act);
        $dias_transc_fin = strtotime($fecha_fin) - $fecha_actual;

        $porc_fin = round($dias_transc_fin / $dias_total_fin * 100, 0);

        $dias_total_cad = strtotime($fecha_caduc) - strtotime($fecha_act);
        $dias_transc_cad = strtotime($fecha_caduc) - $fecha_actual;

        $porc_cad = round($dias_transc_cad / $dias_total_cad * 100, 0);
        
        return view('panel',['emps'=>$emps,'appvisible'=>$appvisible,'rfc'=>$cantrfc,'gigas'=>$cantgigas,'rfccreados'=>count($emps),'apps'=>count($apps),'usrs'=>count($usrs),'bdapps'=>count($bdapps),'porc_final'=>$porc_fin,'porc_cad'=>$porc_cad]);

                
    }

    public function appbyemp(Request $request)
    {
        $alldata = $request->all();
        $return_array = array();
       
        
        if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){
            $empid = $alldata['selected'];
            $emp = Empresa::find($empid);
            $bdapps = BasedatosApp::where('bdapp_empr_id', '=', $empid)->get();

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
}
