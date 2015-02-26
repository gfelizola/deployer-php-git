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
		// dd( Auth::user() );
		
		$usuarios  = User::all()->count();
		$deploys   = Historico::deploys()->count();
		$rollbacks = Historico::rollbacks()->count();
		$media     = number_format( 100 - ( ( $rollbacks * 100 ) / ( $deploys > 0 ? $deploys : 1) ), 2 );

		$historico = Historico::orderBy('created_at', 'DESC')->take(1000)->get();//paginate( Config::get("app.historico_itens", 100) );

		$tratados  = array();
		$dadosGrafDR = array(); //grafico Deploys vs Rollbacks
		$dadosGrafP = array(); //grafico por projeto

		$qtde = 0;
		$max = Config::get("app.historico_itens", 100);

		foreach ($historico as $h) {
			$idx = $h->created_at->format('d.m.Y');
			// $idg = $h->created_at->format('Y-m-d');

			if( isset( $tratados[ $idx ] ) ){
				if( $qtde < $max ) $tratados[ $idx ][] = $h;
			} else {
				$dadosGrafDR[$idx]["deploys"] = 0;
				$dadosGrafDR[$idx]["rollbacks"] = 0;
				if( $qtde < $max ) $tratados[ $idx ] = [$h];
			}

			if( $h->tipo == Historico::TipoDeploy )   $dadosGrafDR[$idx]["deploys"] += 1;
			if( $h->tipo == Historico::TipoRollBack ) $dadosGrafDR[$idx]["rollbacks"] += 1;

			if( ! is_null( $h->projeto ) ){
				$idp = $h->projeto->id;
				if( ! isset( $dadosGrafP[ $idp ] ) ){
					$dadosGrafP[ $idp ] = [
						"deploys"   => 0,
						"rollbacks" => 0,
						"nome"      => $h->projeto->nome,
					];
				}

				if( $h->tipo == Historico::TipoDeploy )   $dadosGrafP[$idp]["deploys"] += 1;
				if( $h->tipo == Historico::TipoRollBack ) $dadosGrafP[$idp]["rollbacks"] += 1;
			}

			$qtde += 1;
		}

		$dadosSaida = array();
		foreach ($dadosGrafDR as $d => $deps) {
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
			"dadosDR"    => json_encode( array_reverse( $dadosSaida ) ),
			"dadosP"     => json_encode( array_reverse( $dadosGrafP ) ),
		);

		return View::make("hello", $dados);
	}

}
