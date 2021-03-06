<?php
use OAuth\OAuth1\Service\BitBucket;
use OAuth\Common\Storage\Session as OauthSession;
use OAuth\Common\Consumer\Credentials;
use Carbon\Carbon;

class UsuarioController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$usuarios = User::orderBy('nome', 'ASC')->orderBy('username', 'ASC')->paginate( Config::get("app.paginacao_itens", 20) );
		return View::make("usuario.index", array('usuarios' => $usuarios));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("usuario.create");
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			"username" => array("required", "unique:users")
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			// var_dump($validator->messages());
		    return Redirect::to("usuario/create")->withErrors($validator);
		} else {
			$usuario = User::create( Input::all() );
			$usuario->roles()->attach(3);

			if(Input::get("admin") ){
				$usuario->roles()->attach(1);
			}

			Historico::create( array(
				"tipo"      => Historico::TipoUsuario,
				"descricao" => "Acesso liberado para o usuário \"{$usuario->username}\"",
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
		return View::make("usuario.show")->with("usuario", User::find($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make("usuario.edit")->with("usuario", User::find($id));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			"nome" => array("required")
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to("usuario/$id/edit")->withErrors($validator);
		} else {
			$usuario = User::find( $id );
			$usuario->nome = Input::get("nome");
			$usuario->skin = Input::get("skin");
			$usuario->layout = ! empty( Input::get("layout") ) ? Input::get("layout") : "";
			$usuario->save();

			$usuario->roles()->sync([3]);

			if(Input::get("admin") ){
				$usuario->roles()->attach(1);
			}

			Historico::create( array(
				"tipo"      => Historico::TipoUsuario,
				"descricao" => "Usuário \"{$usuario->username}\" atualizado",
				"user_id"   => Auth::user()->id
			));
			
			if( Auth::user()->is_admin() ){
				return Redirect::to("usuario");
			} else {
				return Redirect::to("usuario/" . Auth::id() );
			}
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
		User::destroy($id);
		return Response::json( array('sucesso' => true ) );
	}

	

	/**
	 * Mostra tela de login
	 *
	 * @return Response
	 */
	public function loginForm()
	{
		return View::make('login', array("mensagem" => Session::pull("mensagem") ));
	}


	/**
	 * Tenta realizar o login do usuário com o Bitbucket.
	 *
	 * @return Response
	 */
	public function loginWithBitBucket()
	{
		OAuth::setHttpClient("CurlClient");
		$bb = OAuth::consumer('BitBucket');

		if ( ! empty($_GET['oauth_token']) ) {
			$storage = new OauthSession();
		    $token = $storage->retrieveAccessToken('BitBucket');

		    $bb->requestAccessToken(
		        $_GET['oauth_token'],
		        $_GET['oauth_verifier'],
		        $token->getRequestTokenSecret()
		    );

		    $result = json_decode($bb->request('user'));

		    $avatar = $result->user->avatar;
		    $avatar = preg_replace("/s=(\d+)/i", "s=120", $avatar);

			$usuario = User::where('username', '=', $result->user->username)->first();

		    if( $usuario ){
		    	$usuario->nome   = $result->user->display_name;
		    	$usuario->avatar = $avatar;

		    	$usuario->save();

		    	//verifica e realiza bkp do banco de dados
		    	$this->db_backup();

		    	Auth::login($usuario);
		    	return Redirect::to("/");
		    } else {
		    	return Redirect::to("login")->with('mensagem', 'Seu usuário não está cadastrado no sistema.');
		    }

		} else {
	    	$token = $bb->requestRequestToken();
	    	$url = $bb->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
	    	
	    	return Redirect::away((string) $url);
	    	
		}
	}

	

	/**
	 * Realiza logout do usuário
	 *
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout();
		return Redirect::to("login")->with('mensagem', 'Você foi desconectado do sistema com sucesso.');
	}



	

	/**
	 * Realiza backup do banco de dados
	 */
	public function db_backup()
	{
		$hoje   = Carbon::now()->format("Ymd");
		$path   = app_path() . "/database";
		$dbfile = "production.sqlite";
		$bkfile = "production_$hoje.sqlite";
		$bkdir  = "bkp_db";


		if( ! file_exists("$path/$bkdir") ) mkdir("$path/$bkdir");
		if( ! file_exists("$path/$bkdir/$bkfile") ) @copy("$path/$dbfile", "$path/$bkdir/$bkfile");

	}
}