<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Aplicacion;
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


        $appsicons = array ('pld'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='PLD' id='pld'><i class='fa fa-money fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'cont'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Contabilidad' id='cont'><i class='fa fa-bank fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'bov'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Bóveda' id='bov'><i class='fa fa-archive fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'not'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Notaría' id='not'><i class='fa fa-briefcase fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'cc'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Control de calidad' id='cc'><i class='fa fa-tasks fa-3x' style='color:#053666;'></i></a>
                    &nbsp;
                    &nbsp;",
                    'nom'=>"<a href='#' data-toggle='tooltip' data-placement='right' title='Nómina' id='nom'><i class='fa fa-table fa-3x' style='color:#053666;'></i></a>");
        



        $allkeys = array_keys($appsicons);

       /* echo '<pre>';
        print_r($appsicons);die();
        echo '</pre>';*/

        $apps = Aplicacion::all();
        $appvisible = '';


        foreach ($allkeys as $key) {
             $app = Aplicacion::where('app_cod', '=', $key)->get();
             if ($app){
                $appvisible = $appvisible.$appsicons[$key];
             }
            
        }

        //print_r($appvisible);die();
        return view('panel',['emps'=>$emps,'appvisible'=>$appvisible]);

    }
}
