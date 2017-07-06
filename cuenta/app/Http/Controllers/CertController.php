<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Certificado;
use Illuminate\Support\Facades\Validator;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; 

class CertController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {       

        $certificados = Certificado::all();


        foreach ($certificados as $cert ) {
        	
        		if ($cert->cert_f_fin >= date('Y-m-d H:i:s'))
	        	{
	        		$cert->cert_estado = 'Vigente';
	        	}
	        	else
	        	{
	        		
	        		$cert->cert_estado = 'Vencido';
	        	}
        	}
     	

        return view('certificados')->with('certs',$certificados);
    }


    public function create()
    {       

        
       return View::make('certificadocreate');
    }


    public function store(Request $request)
    {
    	
    	
        $alldata = $request->all();
        

        $certf = new Certificado;
        $certf->cert_rfc = $request->cert_rfc;

        if(array_key_exists('cert_file',$alldata) && isset($alldata['cert_file'])){

        	//$rules = ['cert_rfc' => 'required|rfc'];
        	//$messages = ['rfc' => 'RFC inválido'];

        	//$validator = Validator::make($alldata, $rules, $messages)->validate();

        	$cert = request()->file('cert_file');

	        $path = $request->file('cert_file')->storeAs('public', $alldata['cert_rfc'].'.'.$cert->getClientOriginalName());

	        $certf->cert_filename = $cert->getClientOriginalName();
	        $certf->cert_file_storage = $path;



	        //$parseCert = openssl_x509_parse(Storage::disk('local')->get($path));
	        
	        $filecontent = file_get_contents(storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$alldata['cert_rfc'].'.'.$cert->getClientOriginalName());
	        $parseCert = openssl_x509_parse($filecontent);

            if ($parseCert == FALSE) {
                /* Convert .cer to .pem, cURL uses .pem */
                $certificateCApemContent = '-----BEGIN CERTIFICATE-----' . PHP_EOL
                        . chunk_split(base64_encode($filecontent), 64, PHP_EOL)
                        . '-----END CERTIFICATE-----' . PHP_EOL;
                //$certificateCApem = $certificateCAcer . '.pem';
                $parseCert = openssl_x509_parse($certificateCApemContent);
            }

	        $certf->cert_f_inicio = date("Y-m-d H:i:s", $parseCert['validFrom_time_t']);
    		$certf->cert_f_fin = date("Y-m-d H:i:s", $parseCert['validTo_time_t']);

            //print_r($parseCert);die();
        }

    	$certf->save();

        $fmessage = 'Se ha cargado el certificado de rfc: '.$request->cert_rfc;
        $this->registroBitacora($request,'create',$fmessage); 
    	\Session::flash('message',$fmessage);
    	return Redirect::to('certificados');


    }


    public function destroy($id, Request $request)
    {
    	
    	$certf = Certificado::find($id);
        $fmessage = 'Se ha eliminado el certificado: '.$certf->cert_rfc;
        Storage::disk('local')->delete($certf->cert_file_storage);
        $certf->delete();
        $this->registroBitacora($request,'delete',$fmessage); 
        \Session::flash('message',$fmessage);

 	   	return Redirect::to('certificados');


    }
}
