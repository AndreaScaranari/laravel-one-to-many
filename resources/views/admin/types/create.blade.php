@extends('layouts.app')

@section('title', 'Crea Tipologia')

@section('content')
    <header class="text-center py-3">
        <h1>Nuova Tipologia</h1>
    </header>

    <form action="{{ route('admin.types.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Etichetta tipologia --}}
            <div class="col">
                <div class="mb-3">
                    <label for="label" class="form-label">Tipologia</label>
                    <input type="text"
                        class="form-control @error('label') is-invalid @elseif (old('label', '')) is-valid @enderror"
                        id="label" name="label" placeholder="Nome tipologia..." value="{{ old('label', '') }}">
                    @error('label')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="form-text">
                            Inserisci il nome della tipologia
                        </div>
                    @enderror
                </div>
            </div>
            {{-- Colore tipologia --}}
            <div class="col">
                <div class="mb-3">
                    <label for="color" class="form-label">Colore</label>
                    <input type="color"
                        class="form-control @error('color') is-invalid @elseif (old('color', '')) is-valid @enderror"
                        id="color" name="color" placeholder="Esadecimale del colore..."
                        value="{{ old('color', '') }}">
                    @error('color')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="form-text">
                            Inserisci l'esadecimale del colore
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.types.index') }}" class="btn btn-secondary">Torna alla lista</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
        </div>

    @endsection

    @section('scripts')
        @vite('resources/js/image_preview.js')

        <script>
            const titleField = document.getElementById('title');
            const slugField = document.getElementById('slug');

            titleField.addEventListener('blur', () => {
                slugField.value = titleField.value.trim().toLowerCase().split(' ').join('-');
            })
        </script>
    @endsection
