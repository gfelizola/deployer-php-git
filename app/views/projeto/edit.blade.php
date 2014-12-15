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

            <div class="box box-primary">
                <div class="box-body">
                    {{ Form::model($projeto, array('route' => array($rota, $projeto->id))) }}
                    
                        
                            <div class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
                                {{ Form::label("nome", "Nome do projeto") }}
                                {{ Form::text("nome", Input::old("nome"), array( "class" => "form-control" )) }}
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Locais de acesso:</h4>
                                        </div>
                                    </div>
                                                        
                                    <div class="form-group {{{ $errors->has('server_root') ? 'has-error' : '' }}}">
                                        {{ Form::label("server_root", "Server Root") }}
                                        {{ Form::text("server_root", Input::old("server_root"), array( "class" => "form-control" )) }}
                                    </div>
                                                        
                                    <div class="form-group {{{ $errors->has('repo') ? 'has-error' : '' }}}">
                                        {{ Form::label("repo", "URL do repositório") }}
                                        {{ Form::text("repo", Input::old("repo"), array( "class" => "form-control" )) }}
                                    </div>
                                                        
                                    <div class="form-group {{{ $errors->has('repo_branch') ? 'has-error' : '' }}}">
                                        {{ Form::label("repo_branch", "Branch") }}
                                        {{ Form::text("repo_branch", Input::old("repo_branch"), array( "class" => "form-control" )) }}
                                    </div>
                                </div>
                                
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Dados de acesso:</h4>
                                        </div>
                                    </div>
                                                        
                                    <div class="form-group {{{ $errors->has('repo_usuario') ? 'has-error' : '' }}}">
                                        {{ Form::label("repo_usuario", "Usuário de acesso") }}
                                        {{ Form::text("repo_usuario", Input::old("repo_usuario"), array( "class" => "form-control" )) }}
                                    </div>
                                                        
                                    <div class="form-group {{{ $errors->has('repo_senha') ? 'has-error' : '' }}}">
                                        {{ Form::label("repo_senha", "Senha de acesso") }}
                                        {{ Form::text("repo_senha", "", array( "class" => "form-control" )) }}
                                    </div>
                                                        
                                    <div class="form-group {{{ $errors->has('repo_key') ? 'has-error' : '' }}}">
                                        {{ Form::label("repo_key", "Chave de acesso") }}
                                        {{ Form::text("repo_key", Input::old("repo_key"), array( "class" => "form-control" )) }}
                                    </div>
                                </div>
                            </div>
                                                    
                            <div class="form-group">
                                {{ Form::submit('Salvar', array( "class" => "btn btn-primary" )) }}
                            </div>
                    
                    {{ Form::close() }}
                </div>
            </div><!-- /.box -->
        </div>
    </div>
@stop