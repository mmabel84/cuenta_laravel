<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Art69Controller extends Controller
{
    function auditar69b(Request $request) {
        //recibe el rfc en post
        //$rfc = $this->input->post('rfc', TRUE);
        printf('entre');
        $rfc = strtoupper($request->rfc);
        $data['error'] = 1;
        $data['reporte'] = 0;


            //inicializando el cliente (_*-*)_
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
            }
        //retornamos la respuesta del servidor SOAP _(*-*_)
        //echo json_encode($data);
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
        return view('consultaart69');
    }

    function request69consult(Request $request){

        $arrayparams = array();

        /*$arrayparams['by_rfc'] = strtoupper($request['by_rfc']);
        $arrayparams['rfc_value'] = $request['rfc_value'];
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
        $arrayparams['fecha_fin_dof'] = $request['fecha_fin_dof'];*/

        
        /*try
        {
            $service_response = $this->getAppService($acces_vars['access_token'],'get69response',$arrayparams,'control');
            if (count($service_response['response69']) > 0){
                $registros69 = json_decode($service_response['response69']);
            }
        } 
        catch (\GuzzleHttp\Exception\ServerException $e) 
        {
             \Session::put('newserror', 'Sin comunicación a servicio de control para consulta de artículo 69');

        }*/

        //conformacion de consulta para control
        $alldata = null;
        $alldata = $request->all();
        $parameters = [];
        $query = 'select rfc, nombre, oficio, estado, fecha_sat, fecha_dof, url_oficio, url_anexo where ';

        
        if($alldata['by_rfc'] == 1)
        {
            if (array_key_exists('rfc_value',$alldata) && isset($alldata['rfc_value']))
            {
                $query = $query.'rfc = ?';
                array_push($parameters, strtoupper($alldata['rfc_value']));
            }
        }
        else
        {
            $num = 0;

            if (array_key_exists('nombre_value',$alldata) && isset($alldata['nombre_value'])){
                $query = $query."nombre like '%?%' ";
                array_push($parameters, $alldata['nombre_value']);
                $num += 1;
            }

            if (array_key_exists('oficio_value',$alldata) && isset($alldata['oficio_value'])){
                if ($num != 0)
                    $query = $query.'AND oficio = ? ';
                else
                    $query = $query.'oficio = ? ';
                array_push($parameters, $alldata['oficio_value']);
                $num += 1;
            }

            if (array_key_exists('estado_value',$alldata) && isset($alldata['estado_value'])){
                 if ($num != 0)
                    $query = $query.'AND estado in (?';
                else
                    $query = $query.'estado in (?';
                
                array_push($parameters, $alldata['estado_value'][0]);
                for ($i = 1; $i < count($alldata['estado_value']); $i++ )
                {
                    $query = $query.',?';
                    array_push($parameters, $alldata['estado_value'][$i]);
                }
                 $query = $query.') ';
                 $num += 1;
            }

            //by sat
            if ($alldata['by_sat'] == 1){
                if ($alldata['by_sat_specific'] == 1){
                    if (array_key_exists('fecha_esp_sat',$alldata) && isset($alldata['fecha_esp_sat']))
                    {
                        if ($num != 0)
                            $query = $query.'AND fecha_sat = ? ';
                        else
                            $query = $query.'fecha_sat = ? ';
                        array_push($parameters, $alldata['fecha_esp_sat']);
                        $num += 1;
                    }
                }
                else
                {
                    if (array_key_exists('fecha_ini_sat',$alldata) && isset($alldata['fecha_ini_sat']) && array_key_exists('fecha_fin_sat',$alldata) && isset($alldata['fecha_fin_sat']))
                    {
                        if ($num != 0)
                            $query = $query.'AND fecha_sat BETWEEN (? AND ?) ';
                        else
                            $query = $query.'fecha_sat BETWEEN (? AND ?) ';
                        array_push($parameters, $alldata['fecha_ini_sat']);
                        array_push($parameters, $alldata['fecha_fin_sat']);
                        $num += 1;
                    }
                }
            }

            //by dof
            if ($alldata['by_dof'] == 1){
                if ($alldata['by_dof_specific'] == 1){
                    if (array_key_exists('fecha_esp_dof',$alldata) && isset($alldata['fecha_esp_dof']))
                    {
                        if ($num != 0)
                            $query = $query.'AND fecha_dof = ? ';
                        else
                            $query = $query.'fecha_dof = ? ';
                        array_push($parameters, $alldata['fecha_esp_dof']);
                        $num += 1;
                    }
                }
                else
                {
                    if (array_key_exists('fecha_ini_dof',$alldata) && isset($alldata['fecha_ini_dof']) && array_key_exists('fecha_fin_dof',$alldata) && isset($alldata['fecha_fin_dof']))
                    {
                        if ($num != 0)
                            $query = $query.'AND fecha_dof BETWEEN (? AND ?) ';
                        else
                            $query = $query.'fecha_dof BETWEEN (? AND ?) ';
                        array_push($parameters, $alldata['fecha_ini_dof']);
                        array_push($parameters, $alldata['fecha_fin_dof']);
                        $num += 1;
                    }
                }
            }
        }


        //DB::connection($dbname)->select($query,$parameters);

        $registros69 = array(
            array('rfc'=>'rrrrr', 'nombre'=>'rrrrr','estado'=>'rrrr','fecha_sat'=>'rrrr','fecha_dof'=>'rrr','url_oficio'=>'rrrr','url_anexo'=>'rrrr'),
            array('rfc'=>'aaaaa', 'nombre'=>'aaaa','estado'=>'aaaa','fecha_sat'=>'aaaa','fecha_dof'=>'aaaa','url_oficio'=>'aaaa','url_anexo'=>'aaaaa'),
            array('rfc'=>'bbbbb', 'nombre'=>'bbbb','estado'=>'bbbb','fecha_sat'=>'bbbbb','fecha_dof'=>'bbbb','url_oficio'=>'bbbb','url_anexo'=>'bbbb'),
        );

       $response = array(
            'status' => 'Success',
            'msg' => 'Registers returned',
            'registros69' => $registros69,
            'query' => $query,
            'parameters' => $parameters);

         return \Response::json($response);

    }
    
}
