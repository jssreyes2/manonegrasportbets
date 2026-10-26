@extends('layouts.app-backend')
@section('title', 'Banner principal')

@section('page-actions')
    <a href="{{ route('show.principal') }}" target="_blank" class="btn btn-outline-dark">
        <i class="fas fa-external-link-alt mr-1"></i> Ver portada
    </a>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
        </div>
    @endif

    <div class="row">
        {{-- Vista previa de lo publicado --}}
        <div class="col-lg-5 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-eye mr-2"></i>Publicado ahora</h3>
                </div>
                <div class="card-body">
                    <div class="tbh-hero-preview mb-3">
                        @if($hero->show_video)
                            <video muted loop playsinline autoplay poster="{{ $hero->url('poster') }}" class="w-100 d-block">
                                @foreach($hero->sources('desktop') as $source)
                                    <source src="{{ $source['src'] }}" type="{{ $source['type'] }}">
                                @endforeach
                            </video>
                        @else
                            <img src="{{ $hero->url('poster') }}" alt="" class="w-100 d-block">
                        @endif
                        <span class="tbh-hero-preview-shade" style="opacity: {{ $hero->overlay / 100 }}"></span>
                    </div>

                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1"><strong>Escritorio:</strong> {{ $hero->video_desktop ? 'video subido' : 'video de prueba' }}</li>
                        <li class="mb-1"><strong>Móvil:</strong> {{ $hero->video_mobile ? 'video subido' : 'video de prueba' }}</li>
                        <li><strong>Imágenes:</strong> {{ $hero->poster || $hero->poster_mobile ? 'personalizadas' : 'de prueba' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-12 mb-4">
            <div class="card">
                <form method="POST" action="{{ route('hero.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-info small">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Usa clips de 8 a 15 segundos, sin texto ni audio (el titular lo pone la web en cada idioma).
                            Escritorio: 1280×720 o 1920×1080, menos de 3 MB. Móvil: vertical 720×1280, menos de 1.5 MB.
                            Los campos que dejes vacíos conservan el archivo actual.
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label for="video_desktop">Video de escritorio (MP4 o WebM)</label>
                                <input type="file" class="form-control-file" id="video_desktop" name="video_desktop" accept="video/mp4,video/webm">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="video_mobile">Video móvil vertical (MP4 o WebM)</label>
                                <input type="file" class="form-control-file" id="video_mobile" name="video_mobile" accept="video/mp4,video/webm">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="poster">Imagen de carga, escritorio</label>
                                <input type="file" class="form-control-file" id="poster" name="poster" accept="image/jpeg,image/png,image/webp">
                                <small class="form-text text-muted">Se muestra mientras carga el video y a quienes desactivan las animaciones.</small>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="poster_mobile">Imagen de carga, móvil</label>
                                <input type="file" class="form-control-file" id="poster_mobile" name="poster_mobile" accept="image/jpeg,image/png,image/webp">
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label for="overlay">Oscuridad sobre el video: <span id="overlay-value">{{ $hero->overlay }}</span>%</label>
                                <input type="range" class="custom-range" id="overlay" name="overlay" min="20" max="90" step="5" value="{{ old('overlay', $hero->overlay) }}">
                                <small class="form-text text-muted">Más oscuridad = el texto se lee mejor.</small>
                            </div>

                            <div class="form-group col-md-6 col-12 d-flex align-items-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="show_video" name="show_video" value="1" @checked(old('show_video', $hero->show_video))>
                                    <label class="custom-control-label" for="show_video">Mostrar video (si se apaga, solo la imagen)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="tbh-form-actions">
                            <button type="submit" class="btn btn-brand" id="hero-save"><i class="fas fa-check mr-1"></i>Guardar</button>
                            @if($hero->video_desktop || $hero->video_mobile || $hero->poster || $hero->poster_mobile)
                                <button type="submit" form="hero-restore" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo mr-1"></i>Restaurar video de prueba
                                </button>
                            @endif
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('hero.restore') }}" id="hero-restore"
                      onsubmit="return confirm('¿Quitar los archivos subidos y volver al video de prueba?')">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .tbh-hero-preview { position: relative; border-radius: 12px; overflow: hidden; background: #000; aspect-ratio: 16 / 9; }
        .tbh-hero-preview video, .tbh-hero-preview img { height: 100%; object-fit: cover; }
        .tbh-hero-preview-shade { position: absolute; inset: 0; background: #000; pointer-events: none; }
    </style>
@endsection

@section('script')
    <script>
        $('#overlay').on('input', function () {
            $('#overlay-value').text(this.value);
            $('.tbh-hero-preview-shade').css('opacity', this.value / 100);
        });

        // Subir un video puede tardar: se bloquea el botón para evitar envíos dobles
        $('#hero-save').closest('form').on('submit', function () {
            $('#hero-save').prop('disabled', true).html('<span class="spinner-border spinner-border-sm mr-1"></span>Subiendo…');
        });
    </script>
@endsection
