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
                            <form action="{{ route('dashboard.ebook.index') }}" method="get">
                                <div class="input-group-append">
                                    <input value="{{ $q }}" type="text" name="q" class="form-control float-right"
                                           placeholder="Pesquisa">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Título</th>
                            <th>Ano</th>
                            <th>Autores</th>
                            <th>Categorias</th>
                            <th>Gêneros</th>
                            <th>Descrição</th>
                            <th>Comentários</th>
                            <th>Incluído em</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ebooks as $ebook)
                            <tr>
                                <td><img src="{{ $ebook->photoUrl }}" alt="{{ $ebook->id }}" width="100"/></td>
                                <td>{{ $ebook->short_title }}</td>
                                <td>{{ $ebook->year }}</td>
                                <td>{!! $ebook->authors->pluck('name')->implode(',<br>') !!}</td>
                                <td>{!! $ebook->categories->pluck('name')->implode(',<br>') !!}</td>
                                <td>{!! $ebook->genres->pluck('name')->implode(',<br>') !!}</td>
                                <td>{{ $ebook->short_description }}</td>
                                <td>{{ $ebook->comments_count }}</td>
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
