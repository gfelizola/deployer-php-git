<?php

class ProjetoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make("projeto.index")->with("projetos", Projeto::paginate( Config::get("paginacao_itens", 20) ) )->with("message", Session::get("message") );
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("projeto.create", array(
			"projeto" => new Projeto(),
			"rota" => "projeto.store",
		));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), Projeto::$rules);

		if ($validator->fails()) {
			return Redirect::to("projeto/create")->withErrors($validator)->withInput( Input::all() );
		} else {
			$projeto = Projeto::create( Input::all() );

			Historico::create( array(
				"tipo"       => Historico::TipoProjeto,
				"descricao"  => "Projeto criado: \"{$projeto->nome}\"",
				"user_id"    => Auth::user()->id,
				"projeto_id" => $projeto->id,
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
	public function edit($id)
	{
		return View::make("projeto.edit", array(
			"projeto" => Projeto::find($id),
			"rota"    => "projeto/$id/update",
		));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = Projeto::$rules;

		$rules["repo_senha"] = "";

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to("projeto/$id/edit")->withErrors($validator)->withInput( Input::all() );
		} else {
			$projeto               = Projeto::find( $id );
			$projeto->nome         = Input::get("nome");
			$projeto->server_root  = Input::get("server_root");
			$projeto->repo         = Input::get("repo");
			$projeto->repo_branch  = Input::get("repo_branch");
			$projeto->repo_usuario = Input::get("repo_usuario");
			$projeto->repo_senha   = Input::has("repo_senha") ? Input::get("repo_senha") : $projeto->repo_senha;
			$projeto->repo_key     = Input::has("repo_key") ? Input::get("repo_key") : $projeto->repo_key;

			$projeto->save();

			Historico::create( array(
				"tipo"       => Historico::TipoProjeto,
				"descricao"  => "Dados do orojeto atualizados: \"{$projeto->nome}\"",
				"user_id"    => Auth::user()->id,
				"projeto_id" => $projeto->id,
			));
			
			return Redirect::to("projeto")->with("message","Projeto atualizado com sucesso");
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Projeto::destroy($id);
		return Response::json( array('sucesso' => true ) );
	}


}
