@extends('adminlte::page')

@section('title', 'Biblioteca Digital - E-books')

@section('content_header')
    <h1 class="m-0 text-dark">Todos os <b>E-books</b></h1>
@stop

@section('js')
    <script type="text/javascript">
        $(() => {
            $('form input[name="_method"][value="DELETE"]').each((_, e) => {
                $(e).closest('form').on('submit', async function (event) {
                    event.preventDefault();
                    const {value} = await Swal.fire({
                        title: 'Tem certeza?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim, delete isso!'
                    });
                    if (value) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 450px;">
                            <form action="{{ route('dashboard.ebook.index') }}" method="get" style="width: 100%;">
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
                                <td>
                                    {{ $ebook->created_at->format('d/m/y') }}
                                    <br>
                                    {{ $ebook->created_at->diffForHumans() }}
                                    <br>
                                    <form action="{{ route('dashboard.ebook.destroy', $ebook->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>&nbsp;&nbsp;excluir
                                        </button>
                                    </form>
                                </td>
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
