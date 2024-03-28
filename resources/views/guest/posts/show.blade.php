@extends('layouts.app')

@section('title', 'Progetti')

@section('content')
    <div class="card my-5">
        <div class="card-header">
            {{ $project->title }}
        </div>
        <div class="card-body">
            <div class="row">
                @if ($project->image)
                    <div class="col-3">
                        <img src="{{ $project->printImage() }}" alt="{{ $project->title }}">
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
@endsection
