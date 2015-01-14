@extends('layouts.master')

@section('head-extra')
    <link href="/css/select2/select2.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content-header')
    <h1>Deploy<br>
        <small>{{{ $projeto->nome }}} em {{{ $servidor->nome }}}</small>
    </h1>
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
            
            {{ Form::open( array('url' => 'deploy/' . $projeto->id .'/' . $servidor->id .'/realizar' )) }}
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group {{{ $errors->has('tag') ? 'has-error' : '' }}}">
                            {{ Form::label("tag", "Escolha o rótulo de versão (tag)") }}

                            <div class="input-group">
                                {{ Form::select("tag", $tags, Input::old("tag"), array( "class" => "form-control input-lg" )) }}
                            </div>
                        </div>

                        <div class="form-group {{{ $errors->has('descricao') ? 'has-error' : '' }}}">
                            {{ Form::label("descricao", "Descrição do Deploy") }}
                            {{ Form::textarea("descricao", Input::old("descricao"), array( "class" => "form-control" )) }}
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fa fa-cloud-upload"></i> Carregar versão
                            </button>
                        </div>
                    </div>
                </div><!-- /.box -->
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('footer-extra')
    <script src="/js/plugins/select2/select2.min.js" type="text/javascript"></script>
    <script>
        $(function() {
            $("select").select2();
        });
    </script>
@stop