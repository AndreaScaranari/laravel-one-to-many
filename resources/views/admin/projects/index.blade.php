@extends('layouts.app')

@section('title', 'Progetti')

@section('content')
    {{-- Header --}}
    <header class="d-flex align-items-center justify-content-between flex-column">
        <h1 class="m-0">Progetti</h1>
        <div class="d-flex justify-content-between w-100 p-3">
            {{-- Pulsante crea nuovo --}}
            <a href="{{ route('admin.projects.create') }}" class="btn btn-success d-block">
                <i class="fas fa-plus me-2"></i>Nuovo</a>
            {{-- Filtro pubblicati --}}
            <form action="{{ route('admin.projects.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="publication_filter">
                        <option value="">Status</option>
                        <option value="published" @if ($publication_filter === 'published') selected @endif>Pubblicati</option>
                        <option value="drafts" @if ($publication_filter === 'drafts') selected @endif>Bozze</option>
                    </select>
                    <select class="form-select" name="type_filter">
                        <option value="">Tipologie</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" @if ($type_filter == $type->id) selected @endif>
                                {{ $type->label }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Filtra</button>
                </div>
            </form>
            <a href="{{ route('admin.projects.trash') }}" class="btn btn-secondary d-block">
                <i class="fas fa-trash-arrow-up me-2"></i>Guarda Cestino</a>
        </div>
    </header>

    {{-- Intestazione tabella --}}
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Tipologia</th>
                <th scope="col">Status</th>
                <th scope="col">Creato il</th>
                <th scope="col">Ultima modifica</th>
                <th></th>
            </tr>
        </thead>
        {{-- Corpo tabella --}}
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>
                        @if ($project->type)
                            <span class="badge"
                                style="background-color: {{ $project->type->color }}">{{ $project->type->label }}</span>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.projects.toggle', $project) }}" method="POST"
                            class="publication-form" onclick="this.submit()">
                            @csrf
                            @method('PATCH')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="button"
                                    id="{{ 'is_published-' . $project->id }}"
                                    @if ($project->is_published) checked @endif>
                                <label class="form-check-label" for="{{ 'is_published-' . $project->id }}">
                                    {{ $project->is_published ? 'Pubblicato' : 'Bozza' }}</label>
                            </div>
                        </form>
                    </td>
                    <td>{{ $project->getFormattedDate('created_at') }}</td>
                    <td>{{ $project->getFormattedDate('updated_at') }}</td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <h3 class="text-center">Non ci sono progetti da mostrare!</h3>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    @if ($projects->hasPages())
        {{ $projects->links() }}
    @endif

    <section class="my-3" id="type-projects">
        <h3>Progetti per categoria</h3>
        <div class="row row-cols-3">
            @foreach ($types as $type)
                <div class="col">
                    <h4 class="mt-3">{{ $type->label }} ({{ count($type->projects) }})</h4>
                    @forelse ($type->projects as $project)
                        <div>
                            <a href="{{ route('admin.projects.show', $project->id) }}"><em>{{ $project->title }}</em></a>
                        </div>
                    @empty
                        <em>Nessun progetto</em>
                    @endforelse
                </div>
            @endforeach
        </div>
    </section>

@endsection


@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
