@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <header>
        <h1>Il mio portfolio</h1>
        <h3>Scopri i progetti realizzati durante Boolean</h3>
    </header>

    @forelse ($projects as $project)
        <div class="card my-5">
            <div class="card-header d-flex justify-content-between">
                {{ $project->title }}
                <a href="{{ route('guest.project.show', $project->slug) }}" class="btn btn-sm btn-primary">Vedi</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($project->image)
                        <div class="col-3">
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                        </div>
                    @endif
                </div>

                <div class="col">
                    <h5 class="card-title mb-3">{{ $project->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                </div>

                {{-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> --}}
            </div>
        </div>
    @empty
        <h3 class="text-center">Non ci sono progetti da mostrare</h3>
    @endforelse
@endsection
