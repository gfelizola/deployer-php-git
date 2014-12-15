<?php

class ProjetoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make("projeto.index")->with("projetos", Projeto::all() );
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("projeto.edit", array(
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
				"tipo"      => Historico::TipoProjeto,
				"descricao" => "Projeto criado: \"{$projeto->nome}\"",
				"user_id"   => Auth::user()->id
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
			"rota" => "projeto.update",
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
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
