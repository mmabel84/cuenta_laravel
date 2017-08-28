<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Art69Controller extends Controller
{
    function auditar69b(Request $request) {
        
        $rfc = strtoupper($request->rfc);
        Log::info($rfc);
        $data['error'] = 1;
        $data['reporte'] = 0;
        $arrayparams = array();

        $arrayparams['by_rfc'] = true;
        $arrayparams['rfc_value'] = $rfc;

        try
        {
            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'get69response',$arrayparams,'control');
            Log::info($service_response);
            if (count($service_response['response69']) > 0){
                $registros69 = $service_response['response69'];
                $reporte['69b'] = [];
                $reporte['69'] = [];
                $reporte['desvirtuados'] = [];

                foreach ($registros69 as $r) {
                    if ($r->tipo == 'Presunto'){
                       array_push($reporte['69'], $r);
                    }
                    elseif ($r->tipo == 'Definitivo')
                    {
                        array_push($reporte['69b'], $r);
                    }
                    else
                    {
                        array_push($reporte['Desvirtuados'], $r);
                    }

                    
                }
                $data['reporte'] = $this->_reporteA69($reporte,$rfc);
            }
        } 
        catch (\GuzzleHttp\Exception\ServerException $e) 
        {
             \Session::put('newserror', 'Sin comunicación a servicio de control para consulta de artículo 69');

        }
            /*//inicializando el cliente (_*-*)_
            $cliente = new SoapClient(URL_WS_69);//WEB_SERVICE_69 url del webserice definido en constans de Laravel
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
                        $data['reporte'] = $this->_reporteA69($json['reporte'],$rfc);
                    }

                }
                //notificamos que se realizo el proceso sin errores
                $data['error'] = 0;
            }*/
        
        Log::info($data);
        return \Response::json_encode($data);

    }
    function _reporteA69($json69,$rfc){
        //array key probables: \(°-°)/
        //69b
        //69
        //desvirtuados

        //preparando el html
        $html = '';
        $tienerep = false;

        $html .= '<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" name="reporteart" id="reporteart">
  			     <meta name="csrf-token" content="{{ csrf_token() }}" />
  			    
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Reporte de rfc:'. $rfc.'</h5>
                          <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    	</div>

                        <div class="modal-body">
                        <dl class="dl-horizontal">';




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
                                    #'.$json69['69b'][$i]['id'].'<br>
                                    Empresa: '.$json69['69b'][$i]['contribuyente'].'<br>
                                    Numero de oficio: '.$json69['69b'][$i]['oficio'].'<br>
                                    Fecha de SAT: '.$json69['69b'][$i]['fecha_sat'].'<br>
                                    Fecha de DOF: '.$json69['69b'][$i]['fecha_dof'].'<br>
                                    Url de oficio: <a target="_blank" href="'.$json69['69b'][$i]['url_oficio'].'">Ver oficio.pdf</a><br>
                                    Url de oficio: <a target="_blank" href="'.$json69['69b'][$i]['url_anexo'].'">Ver anexo.pdf</a><br>
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
                                    Numero de oficio: '.$json69['69'][$i]['oficio'].'<br>
                                    Fecha de SAT: '.$json69['69'][$i]['fecha_sat'].'<br>
                                    Fecha de DOF: '.$json69['69'][$i]['fecha_dof'].'<br>
                                    Url de oficio: <a target="_blank" href="'.$json69['69'][$i]['url_oficio'].'">Ver oficio.pdf</a><br>
                                    Url de oficio: <a target="_blank" href="'.$json69['69'][$i]['url_anexo'].'">Ver anexo.pdf</a><br>
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
                                    Numero de oficio: '.$json69['desvirtuados'][$i]['oficio'].'<br>
                                    Fecha de SAT: '.$json69['desvirtuados'][$i]['fecha_sat'].'<br>
                                    Fecha de DOF: '.$json69['desvirtuados'][$i]['fecha_dof'].'<br>
                                    Url de oficio: <a target="_blank" href="'.$json69['desvirtuados'][$i]['url_oficio'].'">Ver oficio.pdf</a><br>
                                    Url de oficio: <a target="_blank" href="'.$json69['desvirtuados'][$i]['url_anexo'].'">Ver anexo.pdf</a><br>
                                </li><br>';
                            }
                            $html.='</ul>';
                    }



            }
        }else{
            //si no se encontro nada

            $htmlsinreporte = '<br>
	            		  <div>
	                        <label style="color:#189847;">No se encontraron reportes</label>
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
        $html .='</dl>
                </div>
                
              </div>
            </div>
          </div>';



     	$htmldef = '';      
        if ($tienerep == true){
        	$htmldef = $html;
        }
        else{
        	$htmldef = $htmlsinreporte;
        }

        return $htmldef;
        }

    function consulta69(){

        if (\Auth::check())
        {
            return view('consultaart69');
        }
        else
        {
            return redirect(route('login'));  
        }
        
    }

    function request69consult(Request $request){

        $arrayparams = array();

        if (\Auth::check())
        {
            $arrayparams['by_rfc'] = $request['by_rfc'];
            $arrayparams['rfc_value'] = strtoupper($request['rfc_value']);
            $arrayparams['nombre_value'] = $request['nombre_value'];
            $arrayparams['oficio_value'] = $request['oficio_value'];
            $arrayparams['estado_value'] = $request['estado_value'];
            $arrayparams['by_sat'] = $request['by_sat'];
            $arrayparams['by_sat_specific'] = $request['by_sat_specific'];
            $arrayparams['fecha_esp_sat'] = $request['fecha_esp_sat'];
            $arrayparams['fecha_ini_sat'] = $request['fecha_ini_sat'];
            $arrayparams['fecha_fin_sat'] = $request['fecha_fin_sat'];
            $arrayparams['by_dof'] = $request['by_dof'];
            $arrayparams['by_dof_specific'] = $request['by_dof_specific'];
            $arrayparams['fecha_esp_dof'] = $request['fecha_esp_dof'];
            $arrayparams['fecha_ini_dof'] = $request['fecha_ini_dof'];
            $arrayparams['fecha_fin_dof'] = $request['fecha_fin_dof'];

            $registros69 = [];

            
            try
            {
                $acces_vars = $this->getAccessToken();
                $service_response = $this->getAppService($acces_vars['access_token'],'get69response',$arrayparams,'control');
                Log::info($service_response);
                if (count($service_response['response69']) > 0){
                    $registros69 = $service_response['response69'];
                }
            } 
            catch (\GuzzleHttp\Exception\ServerException $e) 
            {
                 \Session::put('newserror', 'Sin comunicación a servicio de control para consulta de artículo 69');

            }


           $response = array(
                'status' => 'Success',
                'msg' => 'Registers returned',
                'registros69' => $registros69,
                );
        }
        else
        {
            return redirect(route('login'));  
        }

        
         return \Response::json($response);

    }
    
}
