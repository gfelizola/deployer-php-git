@extends('layouts.master')

@section('content-header')
    <h1>Adicionar Usuários</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            
            @if (isset($messages) )
            <div class="alert alert-{{{$message-type}}} alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                
                @foreach( $messages->all('<p>:message</p>') as $message )
                    {{{$messages}}}
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

                    <div class="form-group">
                        {{ Form::submit('Salvar', array( "class" => "btn btn-primary" )); }}
                    </div>
                    
                    {{ Form::close() }}
                </div>
            </div><!-- /.box -->
        </div>
    </div>
@stop