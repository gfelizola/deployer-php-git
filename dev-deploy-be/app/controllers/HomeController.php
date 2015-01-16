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

		$historico = Historico::orderBy('created_at', 'DESC')->take(1000)->get();//paginate( Config::get("app.historico_itens", 100) );

		$tratados  = array();
		$dadosGraf = array();

		$qtde = 0;
		$max = Config::get("app.historico_itens", 100);

		foreach ($historico as $h) {
			$idx = $h->created_at->format('d.m.Y');
			// $idg = $h->created_at->format('Y-m-d');

			if( isset( $tratados[ $idx ] ) ){
				if( $qtde < $max ) $tratados[ $idx ][] = $h;
			} else {
				$dadosGraf[$idx]["deploys"] = 0;
				$dadosGraf[$idx]["rollbacks"] = 0;
				if( $qtde < $max ) $tratados[ $idx ] = [$h];
			}

			if( $h->tipo == Historico::TipoDeploy ) $dadosGraf[$idx]["deploys"] += 1;
			if( $h->tipo == Historico::TipoRollBack ) $dadosGraf[$idx]["rollbacks"] += 1;

			$qtde += 1;
		}

		$dadosSaida = array();
		foreach ($dadosGraf as $d => $deps) {
			$dadosSaida[] = array(
				"y"         => $d,
				"deploys"   => $deps["deploys"],
				"rollbacks" => $deps["rollbacks"]
			);
		}

		$dados = array(
			"usuarios"   => $usuarios,
			"deploys"    => $deploys,
			"rollbacks"  => $rollbacks,
			"media"      => $media,
			"historicos" => $tratados,
			"mensagem"   => Session::pull("mensagem"),
			"dados"      => json_encode( array_reverse( $dadosSaida ) )
		);

		return View::make("hello", $dados);
	}

}
