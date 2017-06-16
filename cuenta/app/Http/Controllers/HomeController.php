<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Aplicacion;
use App\BasedatosApp;
use App\Paquete;
use App\User;
Use View;
use SoapClient;

//define("URL_WS_69", 'http://lista69.advans.mx/Lista69b/index/consultarLista.wdsl');

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


        $appsicons = array ('pld'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='PLD' id='pld' class='disabled'><i class='fa fa-money fa-3x' style='color:#790D4E;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'cont'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Contabilidad' id='cont' class='disabled'><i class='fa fa-bank fa-3x' style='color:#790D4E;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'bov'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Bóveda' id='bov' class='disabled'><i class='fa fa-archive fa-3x' style='color:#790D4E;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'not'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Notaría' id='not' class='disabled'><i class='fa fa-briefcase fa-3x' style='color:#790D4E;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'cc'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Control de calidad' id='cc' class='disabled'><i class='fa fa-tasks fa-3x' style='color:#790D4E;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'nom'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Nómina' id='nom' class='disabled'><i class='fa fa-table fa-3x' style='color:#790D4E;'></i></a>");

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

        $cant_gigas_cons = 0;
        $dict_empr_gig = array();
        

        
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


        


        
        return view('panel',['emps'=>$emps,'appvisible'=>$appvisible,'rfc'=>$cantrfc,'gigas'=>$cantgigas,'rfccreados'=>count($emps),'apps'=>count($apps),'usrs'=>count($usrs),'bdapps'=>count($bdapps),'porc_final'=>$porc_fin,'porc_cad'=>$porc_cad,'fecha_fin'=>$fecha_fin,'fecha_caduc'=>$fecha_caduc,'gigas_cons'=>$cant_gigas_cons,'gigas_empresa'=>json_encode($gigas_cons_emp),'empr_cons'=>json_encode($empr_cons)]);

                
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
                                <label style="color: #3DB1A5" id="norep">No se encontraron reportes</label>
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
