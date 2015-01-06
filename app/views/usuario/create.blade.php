@extends('layouts.master')

@section('content-header')
    <h1>Adicionar Usuários</h1>
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
                    {{ Form::open(array('url' => 'usuario')) }}
                    
                    <div class="form-group {{{ $errors->has('username') ? 'has-error' : '' }}}">
                        {{ Form::label("username", "Nome de usuário no BitBucket") }}<br>
                        {{ Form::text("username", "", array( "class" => "form-control" )) }}
                    </div>
                    
                    <div class="form-group {{{ $errors->has('admin') ? 'has-error' : '' }}}">
                        <label for="admin">
                            {{ Form::checkbox('admin', 1, false ) }}
                                Adicionar com nível de Administrador?
                        </label>
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Salvar', array( "class" => "btn btn-primary" )); }}
                    </div>
                    
                    {{ Form::close() }}
                </div>
            </div><!-- /.box -->
        </div>
    </div>
@stop