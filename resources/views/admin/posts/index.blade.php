@extends('layouts.app')

@section('title', 'Progetti')

@section('content')
    <header class="d-flex align-items-center justify-content-between flex-column">
        <h1 class="m-0">Progetti</h1>
        <div class="d-flex justify-content-between w-100 p-3">
            <a href="{{ route('admin.projectss.create') }}" class="btn btn-success d-block">
                <i class="fas fa-plus me-2"></i>Nuovo</a>
            <form action="{{ route('admin.projectss.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="filter">
                        <option value="">Tutti</option>
                        <option value="published" @if ($filter === 'published') selected @endif>Pubblicati</option>
                        <option value="drafts" @if ($filter === 'drafts') selected @endif>Bozze</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Filtra</button>
                </div>
            </form>
            <a href="{{ route('admin.projectss.trash') }}" class="btn btn-secondary d-block">
                <i class="fas fa-trash-arrow-up me-2"></i>Guarda Cestino</a>
        </div>

    </header>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Pubblicato</th>
                <th scope="col">Creato il</th>
                <th scope="col">Ultima modifica</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projectss as $projects)
                <tr>
                    <th scope="row">{{ $projects->id }}</th>
                    <td>{{ $projects->title }}</td>
                    <td>{{ $projects->slug }}</td>
                    <td>
                        <form action="{{ route('admin.projectss.toggle', $projects) }}" method="POST"
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
                    <td colspan="7">
                        <h3 class="text-center">Non ci sono progetti da mostrare!</h3>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    @if ($projects->hasPages())
        {{ $projects->links() }}
    @endif

@endsection


@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
