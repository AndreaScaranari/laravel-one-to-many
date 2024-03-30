@extends('layouts.app')

@section('title', 'Progetti')

@section('content')
    {{-- Header --}}
    <header class="d-flex align-items-center justify-content-between flex-column">
        <h1 class="m-0">Progetti</h1>
        <div class="d-flex justify-content-between w-100 p-3">
            {{-- Pulsante crea nuovo --}}
            <a href="{{ route('admin.types.create') }}" class="btn btn-success d-block">
                <i class="fas fa-plus me-2"></i>Nuovo</a>
        </div>
    </header>

    {{-- Intestazione tabella --}}
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Label</th>
                <th scope="col">Color</th>
                <th scope="col">Creato il</th>
                <th scope="col">Ultima modifica</th>
                <th></th>
            </tr>
        </thead>
        {{-- Corpo tabella --}}
        <tbody>
            @forelse ($types as $type)
                <tr>
                    <th scope="row">{{ $type->id }}</th>
                    <td>
                        <span class="badge" style="background-color: {{ $type->color }}">{{ $type->label }}
                        </span>
                    </td>
                    <td> {{ $type->color }} </td>
                    <td>{{ $type->getFormattedDate('created_at') }}</td>
                    <td>{{ $type->getFormattedDate('updated_at') }}</td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('admin.types.edit', $type) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.types.destroy', $type->id) }}" method="POST" class="delete-form">
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
                    <td colspan="6">
                        <h3 class="text-center">Non ci sono progetti da mostrare!</h3>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

@endsection


@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
