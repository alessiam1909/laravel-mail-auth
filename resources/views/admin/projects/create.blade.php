@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center"> Aggiungi nuovo progetto alla lista: </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ( $errors->all() as $error )
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('admin.projects.store')}}" method="POST" class="mt-5" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 form-group">
                    <label for="title" class="control-label">Titolo: </label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Inserisci il titolo del progetto">
                </div>
                @error('title')
                    <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="mb-3 form-group">
                    <label for="content" class="control-label">Contenuto: </label>
                    <input type="text" class="form-control" id="content" name="content" placeholder="Inserisci il contenuto">
                </div>
                @error('content')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="mb-3 form-group">
                    <label for="slug" class="control-label">Slug: </label>
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Inserisci lo slug">
                </div>
                @error('slug')
                <div class="text-danger">{{$message}}</div>
                @enderror
                
                <div class="form-group my-3">
                    <label class="control-label">Tipologia: </label>
                    <select class="form-control" name="type_id" id="type_id">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('type_id')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="form-group my-3">
                    <label class="control-label">Tecnologie: </label>
                    @foreach ($technologies as $technology)
                    <div>
                        <input type="checkbox" value="{{ $technology->id }}" name="technologies[]">
                        <label class="form-check-label">{{ $technology->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('technology_id')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="form-group my-3">
                    <label class="control-label">Immagine: </label>
                    <input type="file" name="image" id="image" class="form-control
                    @error('image')is-invalid @enderror">
                    @error('image')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success my-3">
                    Salva
                </button>
            </form>
        </div>
    </div>
</div>

@endsection