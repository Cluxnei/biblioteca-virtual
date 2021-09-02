@extends('adminlte::page')

@section('title', 'Biblioteca Digital - E-books')

@section('content_header')
    <h1 class="m-0 text-dark">Todos os <b>E-books</b></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default" onclick="window.find();">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>Foto</th>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Ano</th>
                            <th>Descrição</th>
                            <th>Incluído em</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ebooks as $ebook)
                            <tr>
                                <td><img src="{{ $ebook->photoUrl }}" alt="{{ $ebook->id }}" width="100"/></td>
                                <td>{{ $ebook->id }}</td>
                                <td>{{ $ebook->short_title }}</td>
                                <td>{{ $ebook->year }}</td>
                                <td>{{ $ebook->short_description }}</td>
                                <td>{{ $ebook->created_at->format('d/m/y') }}
                                    - {{ $ebook->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="container">
                    {{ $ebooks->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
