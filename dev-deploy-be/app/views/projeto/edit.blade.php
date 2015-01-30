@extends('layouts.master')

@section('content-header')
    <h1>Projeto</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            
            @if ( $errors->has() )
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p><b>Aviso!</b></p>
                @foreach( $errors->all('<p>:message</p>') as $message )
                    {{ $message }}
                @endforeach
            </div>
            @endif

            {{ Form::model($projeto, array('route' => array('projeto.update', $projeto->id), 'method' => 'PUT')) }}

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-body">
                            <h4>Infos do projeto:</h4>

                            <div class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
                                {{ Form::label("nome", "Nome do projeto") }}
                                {{ Form::text("nome", Input::old("nome"), array( "class" => "form-control" )) }}
                            </div>
                                                
                            <div class="form-group hidden {{{ $errors->has('server_root') ? 'has-error' : '' }}}">
                                {{ Form::label("server_root", "Server Root") }}
                                {{ Form::text("server_root", Input::old("server_root"), array( "class" => "form-control" )) }}
                            </div>
                                                
                            <div class="form-group {{{ $errors->has('repo') ? 'has-error' : '' }}}">
                                {{ Form::label("repo", "URL do repositório") }}
                                {{ Form::text("repo", Input::old("repo"), array( "class" => "form-control" )) }}
                            </div>
                                                
                            <div class="form-group hidden {{{ $errors->has('repo_branch') ? 'has-error' : '' }}}">
                                {{ Form::label("repo_branch", "Branch") }}
                                {{ Form::hidden("repo_branch", Input::old("repo_branch"), array( "class" => "form-control" )) }}
                            </div>
                        </div>
                    </div>        
                </div>

                <div class="col-sm-6">
                    <div class="box box-warning">
                        <div class="box-body">
                            <h4>Dados de acesso:</h4>
                                                
                            <div class="form-group {{{ $errors->has('repo_usuario') ? 'has-error' : '' }}}">
                                {{ Form::label("repo_usuario", "Usuário de acesso") }}
                                {{ Form::text("repo_usuario", Input::old("repo_usuario"), array( "class" => "form-control" )) }}
                            </div>
                                                
                            <div class="form-group {{{ $errors->has('repo_senha') ? 'has-error' : '' }}}">
                                {{ Form::label("repo_senha", "Senha de acesso") }}
                                {{ Form::password("repo_senha", array( "class" => "form-control" )) }}
                            </div>
                                                
                            <div class="form-group hidden {{{ $errors->has('repo_key') ? 'has-error' : '' }}}">
                                {{ Form::label("repo_key", "Chave de acesso") }}
                                {{ Form::hidden("repo_key", Input::old("repo_key"), array( "class" => "form-control" )) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="box box-danger">
                        <div class="box-body">
                            <h4>Servidores para deploy</h4>
                            <p class="text-danger"><span class="fa fa-warning"></span> <i>Ao selecionar o servidor, defina a pasta raiz onde será realizado o deploy e o branch que será usado</i></p>
                            
                            <div class="form-horizontal">
                                @foreach ($servidores as $servidor)
                                <div class="form-group">
                                    <label class="col-sm-2">{{{ $servidor->nome }}}</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                {{ Form::checkbox('servidor[]', $servidor->id, $projeto->servidores->contains($servidor->id) ? true : false , ["autocomplete"=>"off", "class"=>"simple"] ) }}
                                            </div>
                                        
                                            @if( Input::old("servidor_" . $servidor->id . "_root") )
                                                {{ Form::text("servidor_" . $servidor->id . "_root", Input::old("servidor_" . $servidor->id . "_root"), array( "class" => "form-control", "placeholder" => "raiz (ex. /var/www)" )) }}
                                                {{ Form::text("servidor_" . $servidor->id . "_branch", Input::old("servidor_" . $servidor->id . "_branch"), array( "class" => "form-control", "placeholder" => "branch (ex. master)" )) }}
                                            @elseif( $projeto->servidores->contains($servidor->id) )
                                                {{ Form::text("servidor_" . $servidor->id . "_root", $projeto->servidores->find($servidor->id)->pivot->root, array( "class" => "form-control", "placeholder" => "raiz (ex. /var/www)" )) }}
                                                {{ Form::text("servidor_" . $servidor->id . "_branch", $projeto->servidores->find($servidor->id)->pivot->branch, array( "class" => "form-control", "placeholder" => "branch (ex. master)" )) }}
                                            @else
                                                {{ Form::text("servidor_" . $servidor->id . "_root", "", array( "class" => "form-control", "placeholder" => "raiz (ex. /var/www)" )) }}
                                                {{ Form::text("servidor_" . $servidor->id . "_branch", "", array( "class" => "form-control", "placeholder" => "branch (ex. master)" )) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        {{ Form::submit('Salvar', array( "class" => "btn btn-primary" )) }}
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@stop