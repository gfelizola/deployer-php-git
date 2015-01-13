@extends('layouts.master')

@section('content-header')
    <h1>Servidor</h1>
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
                    {{ Form::model($servidor, array('route' => array('servidor.update', $servidor->id), 'method' => 'PUT')) }}
                        
                            <div class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
                                {{ Form::label("nome", "Nome do servidor") }}
                                {{ Form::text("nome", Input::old("nome"), array( "class" => "form-control" )) }}
                            </div>

                            <div class="form-group {{{ $errors->has('tipo_acesso') ? 'has-error' : '' }}}">
                                <label for="tipo_acesso_shh">
                                    {{ Form::radio('tipo_acesso', Servidor::TIPO_SSH, $servidor->tipo_acesso ? $servidor->tipo_acesso == Servidor::TIPO_SSH : true, ["id"=>"tipo_acesso_ssh"] ) }}
                                        SSH <small><i class="text-info">(servidor externo)</i></small>
                                </label><br>

                                <label for="tipo_acesso_local">
                                    {{ Form::radio('tipo_acesso', Servidor::TIPO_LOCAL, $servidor->tipo_acesso ? $servidor->tipo_acesso == Servidor::TIPO_LOCAL : false, ["id"=>"tipo_acesso_local"]) }}
                                        Local <small><i class="text-info">(mesmo servidor do Deployer)</i></small>
                                </label>
                            </div>

                            <h4>Preencher os valores abaixo para acesso SSH</h4>
                                                        
                            <div class="form-group {{{ $errors->has('endereco') ? 'has-error' : '' }}}">
                                {{ Form::label("endereco", "Endereço") }}
                                {{ Form::text("endereco", Input::old("endereco"), array( "class" => "form-control" )) }}
                            </div>
                                                
                            <div class="form-group {{{ $errors->has('usuario') ? 'has-error' : '' }}}">
                                {{ Form::label("usuario", "Usuário de acesso") }}
                                {{ Form::text("usuario", Input::old("usuario"), array( "class" => "form-control" )) }}
                            </div>
                                                
                            <div class="form-group {{{ $errors->has('senha') ? 'has-error' : '' }}}">
                                {{ Form::label("senha", "Senha de acesso") }}
                                {{ Form::password("senha", array( "class" => "form-control" )) }}
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