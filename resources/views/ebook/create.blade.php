@extends('adminlte::page')

@section('title', 'Biblioteca Digital - Adicionar um e-books')

@section('content_header')
    <h1 class="m-0 text-dark">Adicionar um <b>e-book</b></h1>
@stop

@section('js')
    <script type="text/javascript">
        $(() => {
            $('#store-ebook-form select').select2({
                width: '100%',
            });
        });
    </script>
    @if(\Illuminate\Support\Facades\Session::has('success'))
        <script type="text/javascript">
            @if (\Illuminate\Support\Facades\Session::get('success'))
            Swal.fire('Sucesso', 'Ação finalizada com sucesso', 'success');
            @else
            Swal.fire('Ops...', 'Ocorreu um problema ao finalizar sua ação', 'error');
            @endif
        </script>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('dashboard.ebook.store') }}" method="post" enctype="multipart/form-data"
                      id="store-ebook-form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Título</label>
                            <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control"
                                   placeholder="Título">
                        </div>
                        <div class="form-group">
                            <label for="year">Ano</label>
                            <input value="{{ old('year') }}" type="number" min="1" max="{{ date('Y') }}" name="year"
                                   id="year" class="form-control" placeholder="Ano">
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea name="description" id="description" class="form-control"
                                      placeholder="Descrição">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cover_file">Foto de capa</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="cover_file" class="custom-file-input" id="cover_file"
                                           accept="image/*">
                                    <label class="custom-file-label" for="cover_file">Foto de capa</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pdf_file">PDF</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="pdf_file" class="custom-file-input" id="pdf_file"
                                           accept="application/pdf">
                                    <label class="custom-file-label" for="pdf_file">PDF</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="authors">Autor(es)</label>
                            <select name="authors[]" id="authors" class="form-control" multiple="multiple">
                                @foreach($authors as $author)
                                    @if (in_array($author->id, old('authors') ?? []))
                                        <option value="{{ $author->id }}" selected>{{ $author->name }}</option>
                                    @else
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="genres">Gênero(s)</label>
                            <select name="genres[]" id="genres" class="form-control" multiple="multiple">
                                @foreach($genres as $genre)
                                    @if (in_array($genre->id, old('genres') ?? []))
                                        <option value="{{ $genre->id }}" selected>{{ $genre->name }}</option>
                                    @else
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categoria(s)</label>
                            <select name="categories[]" id="categories" class="form-control" multiple="multiple">
                                @foreach($categories as $category)
                                    @if (in_array($category->id, old('categories') ?? []))
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
