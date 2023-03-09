@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row d-flex flex-wrap ">
            <h1 class="col-12 my-5 text-info">
                Elenco dei progetti: 
            </h1>
        @foreach ( $projects as $project )
        <div class="card-group">
            <a href="{{route('admin.projects.show',  ['project' => $project['slug']])}}">
                <div class="card">
                    <img class="card-img-top" src="{{asset('storage/' .$project->image)}}" alt="{{$project->title}}">
                        <div class="card-body">
                            <h5 class="card-title">{{$project->title}}</h5>
                            <p class="card-text">{{$project->content}}</p>
                            <p class="card-text">  @if ($project->type_id)
                               Tipologia: {{$project->type->name}}
                              @else
                                Tipologia non disponibile
                              @endif</p>
                            <p>Tecnologie:
                                @forelse ($project->technologies as $technology)
                                {{ $loop->first ? '' : ', ' }}
                                <span>{{ $technology->name }}</span>
                                @empty
                                Nessuna tecnologia utilizzata
    
                                @endforelse
                            </p>
                              <p class="card-text"> </p>
                            <p class="card-text my-4"><small class="text-muted">Last updated 3 mins ago</small></p>
                            <a href="{{route('admin.projects.edit', ['project' =>$project->slug])}}" class="btn btn-md btn-square btn-warning">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="{{route('admin.projects.create')}}" class="btn btn-md btn-square btn-success">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <form action="{{route('admin.projects.destroy',  $project->slug)}}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-md btn-danger btn-square">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>

            @endforeach
        </div>
    </div>
@endsection