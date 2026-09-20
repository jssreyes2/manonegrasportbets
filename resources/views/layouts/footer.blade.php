<footer class="footer-sencillo">
    <div class="footer-contenido">
        <div class="footer-columna1">
            <p class="footer-products">Productos</p>
            <p class="footer-ios">Atrévete App Ios</p>
            <p class="footer-android">Atrévete App Android</p>
            <p class="footer-desktop">Atrévete para Escritorios</p>
        </div>
        <div class="footer-columna2">
            <p class="footer-comunidad">Comunidad</p>
            <p class="footer-Mentores href-write" title="Mentores Oficiales"><a href="{{route('show.view.mentoring')}}">Mentores Oficiales</a></p>
            <p class="footer-blog href-write" title="Blog"><a href="{{route('get.blog')}}">Blog</a></p>
            <p class="footer-blog href-write" title="zona de Descargas"><a href="{{route('show.login')}}">Zona de Descargas</a></p>
        </div>
        <div class="footer-columna3">
            <p class="footer-soporte">Soporte</p>
            <p class="footer-F&Q href-write" title="Preguntas Frecuentes"><a href="{{route('show.view.freelancers')}}">Preguntas Frecuentes (F&Q)</a></p>
            <p class="footer-T&C href-write" title="Términos y Condiciones"><a href="{{route('show.terms.and.conditions')}}">Términos y Condiciones</a></p>
            <p class="footer-PP href-write" title="Política de Privacidad"><a href="{{route('show.privacy.policies')}}">Política de Privacidad</a></p>
            <p class="footer-PP href-write" title="Política de Cookies"><a href="{{route('show.cookies.policy')}}">Política de Cookies</a></p>
        </div>
        <div class="footer-columna4">
            <p class="footer-contact">Contáctanos</p>
            <p class="footer-mail href-write" title="Enviar un email"><a href="mailto:{{$parameter->email}}">{{$parameter->email}}</a></p>
            <p class="footer-number href-write" title="WhatsApp"><a href="https://wa.me/{{$parameter->phone}}?text=Hola%20me%20comunico%20desde%20la%20web" target="_blank">+{{$parameter->phone}}</a></p>
        </div>
        <div class="footer-columna5">
            <a href="/"><img class="Logo-footer" src="{{asset('Imagenes/logotipo-blanco.png')}}" alt="logotipo-mordado"></a>
            <div class="footer-rrss">

                <a href="https://www.instagram.com/{{$parameter->social_network_instagram}}" target="_blank" rel="noopener noreferrer" title="Instagram">
                    <img class="rrss-icon" src="{{asset('Imagenes/iconos/Instagram-icon.png')}}" alt="social icon">
                </a>

                <a href="https://www.facebook.com/{{$parameter->social_network_facebook}}" target="_blank" rel="noopener noreferrer" title="Facebook">
                    <img class="rrss-icon" src="{{asset('Imagenes/iconos/Facebook-icon.png')}}" alt="social icon">
                </a>
                
                <a href="https://www.tiktok.com/{{$parameter->social_network_tiktok}}" target="_blank" rel="noopener noreferrer" title="Tiktok"><img class="rrss-icon" src="{{asset('Imagenes/iconos/tiktok-icon.png')}}" alt="social icon"></a>
{{--                <a href="#"><img class="rrss-icon" src="{{asset('Imagenes/iconos/Discord-icon.png')}}" alt="social icon"></a>--}}
            </div>
        </div>
    </div>
    <p class="footer-copy">&copy; 2025 Atrévete. Todos los derechos reservados.</p>
</footer>