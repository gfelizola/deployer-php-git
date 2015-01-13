<?php

class ServidorController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make("servidor.index")->with("servidores", Servidor::paginate( Config::get("app.paginacao_itens", 20) ) )->with("message", Session::get("message") );
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("servidor.create", array(
			"servidor" => new Servidor(), 
		));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), Servidor::$rules);

		if ($validator->fails()) {
			return Redirect::to("servidor/create")->withErrors($validator)->withInput( Input::all() );
		} else {
			$servidor = Servidor::create( Input::all() );

			Historico::create( array(
				"tipo"       => Historico::TipoServidor,
				"descricao"  => "Servidor criado: \"{$servidor->nome}\"",
				"user_id"    => Auth::user()->id
			));
			
			return $this->index();
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->edit($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($servidor)
	{
		// dd($id);
		return View::make("servidor.edit", array(
			"servidor" => $servidor
		));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($servidor)
	{
		$rules = Servidor::$rules;

		$rules["senha"] = "";

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to("servidor/{$servidor->id}/edit")->withErrors($validator)->withInput( Input::all() );
		} else {
			// $servidor             = Servidor::find( $id );
			$servidor->nome        = Input::get("nome");
			$servidor->endereco    = Input::get("endereco");
			$servidor->usuario     = Input::get("usuario");
			$servidor->tipo_acesso = Input::get("tipo_acesso");
			$servidor->senha       = Input::has("senha") ? Input::get("senha") : $servidor->senha;

			$servidor->save();

			Historico::create( array(
				"tipo"       => Historico::TipoServidor,
				"descricao"  => "Dados do servidor atualizados: \"{$servidor->nome}\"",
				"user_id"    => Auth::user()->id
			));
			
			return Redirect::to("servidor")->with("message","Servidor atualizado com sucesso");
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($servidor)
	{
		Servidor::destroy($servidor->id);
		return Response::json( array('sucesso' => true ) );
	}
}
