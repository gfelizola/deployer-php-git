<?php

class ProjetoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make("projeto.index")->with("projetos", Projeto::paginate( Config::get("app.paginacao_itens", 20) ) )->with("message", Session::get("message") );
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("projeto.create", array(
			"projeto"    => new Projeto(),
			"rota"       => "projeto.store",
			"servidores" => Servidor::orderBy("nome")->get()
		));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = Projeto::$rules;
		$servidores = Input::get("servidor");

		$messages = array();

		// dd($servidores);

		if($servidores){
			foreach ($servidores as $s){
			    $rules["servidor_".$s."_root"] = "required";
			    $messages["servidor_".$s."_root.required"] = "O campo 'raiz' dos servidores selecionados é obrigatório.";
			}
		}

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			return Redirect::to("projeto/create")->withErrors($validator)->withInput( Input::all() );
		} else {
			$projeto = Projeto::create( Input::all() );
			$servidores_salva = array();

			foreach ($servidores as $s) {
				$servidores_salva[$s] = array( "root" => Input::get("servidor_" . $s . "_root") );
			}

			$projeto->servidores()->sync( $servidores_salva );

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
			"projeto"    => Projeto::find($id),
			"rota"       => "projeto/$id/update",
			"servidores" => Servidor::orderBy("nome")->get()
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
		$messages = array();
		$servidores = Input::get("servidor");
		$rules = Projeto::$rules;
		$rules["repo_senha"] = "";

		if($servidores){
			foreach ($servidores as $s){
			    $rules["servidor_".$s."_root"] = "required";
			    $messages["servidor_".$s."_root.required"] = "O campo 'raiz' dos servidores selecionados é obrigatório.";
			}
		}

		$validator = Validator::make(Input::all(), $rules, $messages);

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

			$servidores = Input::get("servidor");

			$servidores_salva = array();

			foreach ($servidores as $s) {
				$servidores_salva[$s] = array( "root" => Input::get("servidor_" . $s . "_root") );
			}

			$projeto->servidores()->sync( $servidores_salva );

			Historico::create( array(
				"tipo"       => Historico::TipoProjeto,
				"descricao"  => "Dados do projeto atualizados: \"{$projeto->nome}\"",
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


	/**
	 * Lista os deploys do projeto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deploys($id)
	{
		$projeto = Projeto::find($id);
		$deploys = Deploy::orderBy("created_at","DESC")->where("projeto_id","=",$id)->paginate( Config::get("app.paginacao_itens", 20) );
		
		return View::make( "deploy.index", array(
			"projeto" => $projeto,
			"deploys" => $deploys,
			"message" => Session::get("message")
		));
	}


}
