<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That"s great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get("/", "HomeController@showWelcome");
	|
	*/

	public function showWelcome()
	{
		$usuarios  = User::all()->count();
		$deploys   = Historico::deploys()->count();
		$rollbacks = Historico::rollbacks()->count();
		$media     = number_format( 100 - ( ( $rollbacks * 100 ) / ( $deploys > 0 ? $deploys : 1) ), 2 );

		$historico = Historico::orderBy('created_at', 'DESC')->paginate( Config::get("historico_itens", 30) );

		$tratados = array();

		foreach ($historico as $h) {
			$idx = $h->created_at->format('d.m.Y');
			if( isset( $tratados[ $idx ] ) ){
				$tratados[ $idx ][] = $h;
			} else {
				$tratados[ $idx ] = [$h];
			}
		}

		$dados = array(
			"usuarios"   => $usuarios,
			"deploys"    => $deploys,
			"rollbacks"  => $rollbacks,
			"media"      => $media,
			"historicos" => $tratados,
		);

		return View::make("hello", $dados);
	}

}
