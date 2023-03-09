@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center"> Modifica il progetto {{$project->title}} </h1>
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
            <form action="{{route('admin.projects.update', $project->slug)}}" method="POST" class="mt-5" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3 form-group">
                    <label for="title" class="control-label">Titolo: </label>
                    <input type="text" class="form-control" id="title" name="title" value="{{old('title') ?? $project->title}}">
                </div>
                @error('title')
                    <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="mb-3 form-group">
                    <label for="content" class="control-label">Contenuto: </label>
                    <input type="text" class="form-control" id="content" name="content" value="{{old('title') ?? $project->content}}">
                </div>
                @error('content')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="mb-3 form-group">
                    <label for="slug" class="control-label">Slug: </label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{old('title') ?? $project->slug}}">
                </div>
                @error('slug')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="form-group my-3">
                    <label class="control-label">Tipo</label>
                    <select class="form-control" name="type_id" id="type_id">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $type->id == old('type_id', $project->type_id) ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
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
                            @if ($errors->any())
                                <input type="checkbox" value="{{ $technology->id }}" name="technologies[]" {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $technology->name }}</label>
                            @else
                            <input type="checkbox" value="{{ $technology->id }}" name="technologies[]" {{ $project->technologies->contains($technology) ? 'checked' : ''  }}>
                            <label class="form-check-label">{{ $technology->name }}</label>
                            @endif
                        </div>
                    @endforeach
                </div>
                @error('technology_id')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <div class="mb-3 form-group">
                    <label for="image" class="control-label">Url immagine: </label>
                    <input type="text" class="form-control" id="image" name="image" value="{{old('title') ?? $project->image}}">
                </div>
                @error('image')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <button type="submit" class="btn btn-success my-3">
                    Salva
                </button>
            </form>
        </div>
    </div>
</div>

@endsection