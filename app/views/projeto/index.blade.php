@extends('layouts.master')

@section('content-header')
    <h1>Projetos</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">

            @if (isset($message) )
            <div class="alert alert-success alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{{$message}}}
            </div>
            @endif

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Lista de projetos</h3>
                    <div class="box-tools">
                        <a href="{{{ URL::to('projeto/create') }}}" class="btn bg-navy pull-right">Adicionar novo</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Ações</th>
                            <th>Nome</th>
                            <th>Repo</th>
                            <th>Data de Cadastro</th>
                        </tr>

                        @foreach ($projetos as $projeto)
                        <tr>
                            <td width="70">
                                <a href="{{{ URL::to('projeto', array($projeto->id, 'edit')) }}}" class="btn btn-success btn-xs">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{{ URL::to('projeto', array($projeto->id)) }}}" class="btn btn-danger btn-xs">
                                    <i class="fa fa-ban"></i>
                                </a>
                            </td>
                            
                            <td>{{ $projeto->nome }}</td>
                            <td>{{ $projeto->repo }}</td>
                            <td>{{ $projeto->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop