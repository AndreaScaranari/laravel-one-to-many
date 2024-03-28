@extends('layouts.app')

@section('title', 'Progetti')

@section('content')
    <header>
        <h1 class="text-center pb-3">{{ $projects->title }}</h1>
    </header>

    <div class="clearfix">
        @if ($projects->image)
            <img src="{{ $projects->printImage() }}" alt="{{ $projects->title }}" class="me-2 float-start">
        @endif
        <p>{{ $projects->content }}</p>
        <div>
            <strong>Creato il:</strong> {{ $projects->getFormattedDate('created_at', 'd-m-Y H:i:s') }}
            <strong>Ultima modifica il:</strong> {{ $projects->getFormattedDate('updated_at', 'd-m-Y H:i:s') }}
        </div>
    </div>

    <footer class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.projectss.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Torna indietro
        </a>
        <div class="d-flex justify-content-between gap-2">
            <a href="{{ route('admin.projectss.edit', $projects) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-pencil me-2"></i>
                Modifica
            </a>
            <form action="{{ route('admin.projectss.destroy', $projects->id) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash me-2" data-bs-toggle="modal" data-bs-target="#modal"></i>
                    Elimina
                </button>
            </form>
        </div>
    </footer>
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
