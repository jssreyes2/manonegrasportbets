@extends('layouts.app_web')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/home-responsive.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">

        <main class="main-content">
            @include('layouts.menu_movile')

            <div id="contenido-inicio" class="contenido-seccion">
                <div class="carousel-container">

                    <div class="carousel-slides">
                        @foreach($banners As $item)
                            <div class="slide" style="background-image: url('storage/photo_page/banner/{{$item->photo}}');"></div>
                        @endforeach
                    </div>
                    <button class="carousel-arrow prev" id="prevBtn">&#10094;</button>
                    <button class="carousel-arrow next" id="nextBtn">&#10095;</button>
                    <div class="carousel-dots"></div>
                </div>
                <section class="info-inicio">
                    <div class="texto-inicio">
                        <h1>Convierte tus ideas en experiencias únicas con Atrévete.</h1>
                        <p class="descripcion">Hemos creado la plataforma definitiva para creadores conscientes. Un solo lugar donde encuentras mentores de élite, freelancers expertos, cursos que sí funcionan y una comunidad que eleva tu energía. Todo lo
                            que necesitas para sanar, vender y expandirte está aquí.</p>
                        <a class="inicio-login-btn" href="{{route('show.login')}}">Empieza a Crear</a>
                    </div>
                    <nav class="boton-seccions" aria-label="Secciones principales">
                        <a href="{{route('show.view.freelancers')}}" class="boton-freelancers">Freelancers</a>
                        <a href="{{route('show.view.mentoring')}}" class="boton-mentorias">Mentorías</a>
                        <a href="{{route('show.view.marketplace')}}" class="boton-marketplace">Marketplace</a>
                        <a href="{{route('show.contact')}}" class="boton-freelancers">Contáctanos</a>
                    </nav>
                </section>
                <section class="inicio-zona1">
                    <h2>Todo lo que necesitas para <span class="triunfar">triunfar</span></h2>
                    <p>Una plataforma integral diseñada para acelerar tu crecimiento personal y profesional</p>
                    <div class="tarjetas">
                        <ul class="contenedor-de-tarjetas" role="list">
                            <li>
                                <div class="tarjeta1">
                                    <img src="{{asset('Imagenes/Profile-Pictures/zombie-kawaii.jpg')}}" class="icono-tarjeta1">
                                    <h3>Comunidad Colaborativa</h3>
                                    <p>Únete a nuestra red exclusiva de emprendedores, freelancers y creadores. Comparte conocimientos, encuentra sinergias y crece junto a mentes que inspiran.</p>
                                </div>
                            </li>
                            <li>
                                <div class="tarjeta2">
                                    <img src="{{asset('Imagenes/Profile-Pictures/zombie-kawaii.jpg')}}" class="icono-tarjeta2">
                                    <h3>Asesoría Estratégica</h3>
                                    <p>Conecta con mentores expertos en mentalidad, ventas y marketing para acelerar tu crecimiento.</p>
                                </div>
                            </li>
                            <li>
                                <div class="tarjeta3">
                                    <img src="{{asset('Imagenes/Profile-Pictures/zombie-kawaii.jpg')}}" class="icono-tarjeta3">
                                    <h3>Marketplace de Conocimiento</h3>
                                    <p>Explora una vasta biblioteca de ebooks, masterclass, cursos y plantillas premium. Recursos curados por expertos para potenciar tus habilidades y tus ingresos.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>
                <section class="cta-final-seccion">
                    <div class="cta-contenido">
                        <h2>¿Listo para dar el siguiente paso?</h2>
                        <div class="cta-cajas" role="group" aria-label="Opciones de registro">
                            <div class="cta-caja cta-cliente">
                                <h3>Busco un Experto</h3>
                                <p>Explora perfiles y encuentra el talento validado que tu proyecto necesita para brillar.</p>

                                @if(!Auth::user() instanceof \App\Models\User)
                                    <a href="{{route('show.login')}}" class="btn-cta btn-cta-primario">Contactar</a>
                                @else
                                    <a href="{{route('user.get.freelancer')}}" class="btn-cta btn-cta-primario">Contactar</a>
                                @endif
                            </div>

                            @if(!Auth::user() instanceof \App\Models\User)
                                <div class="cta-caja cta-freelancer">
                                    <h3>Soy un Freelancer</h3>
                                    <p>Únete a nuestra red de expertos, conecta con clientes con propósito y eleva tu carrera.</p>
                                    <a href="{{route('show.register')}}" class="btn-cta btn-cta-secundario">Aplicar para Unirme</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            @include('layouts.footer')
        </main>

    </div>
@endsection