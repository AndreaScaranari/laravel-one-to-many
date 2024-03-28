@if ($project->exists)
    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data"
        novalidate>
        @method('PUT')
    @else
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" novalidate>
@endif

@csrf
<div class="row">
    <div class="col-8">
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text"
                class="form-control @error('title') is-invalid @elseif (old('title', '')) is-valid @enderror"
                id="title" name="title" placeholder="Titolo..." value="{{ old('title', $project->title) }}"
                required>
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="form-text">
                    Inserisci il titolo del project
                </div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug"
                value="{{ Str::slug(old('slug', $project->title)) }}" disabled>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <label for="content" class="form-label">Contenuto del Progetto</label>
            <textarea class="form-control @error('content') is-invalid @elseif (old('content', '')) is-valid @enderror"
                name="content" id="content" rows="12" required>
                        {{ old('content', $project->content) }}
            </textarea>
        </div>
        @error('content')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div class="form-text">
                Inserisci il contenuto del progetto
            </div>
        @enderror
    </div>
    <div class="col-11">
        <div class="mb-3">
            {{-- # In precedenza per l'url --}}

            {{-- <label for="image" class="form-label">Image</label>
            <input type="url" class="form-control" name="image" id="image" placeholder="http:// o https://"
                value="{{ old('image', $project->image) }}">
        </div>
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div class="form-text">
                Inserisci l'URL assoluto di un file immagine
            
        @enderror --}}
            {{-- # Forma corretta ma non posso inserire il value a causa del fatto che i type=file non accettano questa proprietà --}}
            {{-- <div class="mb-3">
            <label for="image" class="form-label">Carica un file immagine</label>
            <input type="file" class="form-control" name="image" id="image"
                placeholder="Nessun file selezionato">
        </div> --}}
            {{-- # trick per usare il value --}}
            <label for="image" class="form-label">Carica un file immagine</label>

            <div @class(['input-group', 'd-none' => !$project->image]) id="old-img-field">
                <button class="btn btn-outline-secondary" type="button" id="change-image-button">Cambia
                    immagine</button>
                <input type="text" class="form-control" value="{{ old('image', $project->image) }}" disabled>
            </div>

            <input type="file"
                class="form-control @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror @if ($project->image) d-none @endif"
                name="image" id="image" placeholder="Nessun file selezionato">
        </div>

        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div class="form-text">
                Carica un file immagine
            </div>
        @enderror
    </div>
    <div class="col-1">
        <div class="mb-3">
            <img src="{{ old('image', $project->image) ? $project->printImage() : 'https://marcolanci.it/boolean/assets/placeholder.png' }}"
                class="img-fluid" alt=" {{ $project->image ? $project->title : 'Immagine del progetto' }} "
                id="preview" name="preview">
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="is_published" name="is_published"
                @if (old('is_published', $project->is_published)) checked @endif>
            <label class="form-check-label" for="is_published">
                Pubblicato
            </label>
        </div>
    </div>
</div>
<div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Torna alla lista</a>

    <div class="d-flex align-items-center gap-2">
        <button type="reset" class="btn btn-warning"><i class="fas fa-eraser me-2"></i> Svuota i
            campi</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
    </div>
</div>
</form>
