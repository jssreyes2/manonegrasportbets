{{-- Campana del cliente: picks nuevos sin ver + activación de avisos push --}}
@php $B = fn($key) => __t('text.backend.customer.' . $key); @endphp

<li class="nav-item dropdown" id="tbhBell">
    <a class="nav-link tbh-bell-btn" data-toggle="dropdown" href="#" role="button" aria-label="{{ $B('bell_title') }}">
        <i class="far fa-bell"></i>
        <span class="tbh-bell-badge d-none" id="tbhBellCount">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right tbh-bell-menu">
        <div class="tbh-bell-head">{{ $B('bell_title') }}</div>
        <div id="tbhBellList"><div class="tbh-bell-empty">{{ $B('bell_empty') }}</div></div>
        <a href="{{ route('picks.index') }}" class="tbh-bell-foot">{{ $B('bell_view_all') }} <i class="fas fa-arrow-right ml-1"></i></a>
        <button type="button" class="tbh-bell-push d-none" id="tbhPushToggle"></button>
    </div>
</li>

<style>
    .tbh-bell-btn { position: relative; font-size: 1.15rem; }
    .tbh-bell-badge { position: absolute; top: 2px; right: 2px; min-width: 18px; height: 18px; padding: 0 5px; border-radius: 9px;
        background: #dc3545; color: #fff; font-size: 11px; font-weight: 700; line-height: 18px; text-align: center; }
    .tbh-bell-menu { width: 320px; max-width: 92vw; padding: 0; overflow: hidden; }
    .tbh-bell-head { padding: 10px 14px; font-weight: 700; border-bottom: 1px solid rgba(0,0,0,.08); }
    .tbh-bell-item { display: block; padding: 10px 14px; border-bottom: 1px solid rgba(0,0,0,.06); color: inherit; }
    .tbh-bell-item strong { display: block; font-size: .9rem; }
    .tbh-bell-item span { font-size: .78rem; opacity: .7; }
    .tbh-bell-empty { padding: 18px 14px; text-align: center; opacity: .7; font-size: .9rem; }
    .tbh-bell-foot { display: block; padding: 10px 14px; text-align: center; font-weight: 700; font-size: .85rem; }
    .tbh-bell-push { display: block; width: 100%; padding: 9px 14px; border: 0; border-top: 1px solid rgba(0,0,0,.08);
        background: transparent; font-size: .8rem; }
    .tbh-bell-push:hover { background: rgba(0,0,0,.04); }
</style>

<script>
    // Se ejecuta al cargar la página: jQuery y Bootstrap se incluyen al final del layout
    window.addEventListener('load', function () {
        const urls = {
            list:  @json(route('customer.notifications.index')),
            seen:  @json(route('customer.notifications.seen')),
            push:  @json(route('customer.notifications.push.subscribe')),
            sw:    @json(asset('sw.js')),
        };
        const vapidKey = @json(config('webpush.vapid.public_key'));
        const txt = {
            enable:   @json($B('push_enable')),
            disable:  @json($B('push_disable')),
            enabled:  @json($B('push_enabled')),
            denied:   @json($B('push_denied')),
            empty:    @json($B('bell_empty')),
        };
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const $count = document.getElementById('tbhBellCount');
        const $list = document.getElementById('tbhBellList');
        const $toggle = document.getElementById('tbhPushToggle');
        const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

        const api = (url, method, body) => fetch(url, {
            method: method || 'GET',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: body ? JSON.stringify(body) : undefined,
            credentials: 'same-origin',
        }).then((r) => r.json());

        function render(data) {
            $count.textContent = data.count > 99 ? '99+' : data.count;
            $count.classList.toggle('d-none', !data.count);
            $list.innerHTML = data.items.length
                ? data.items.map((i) => '<a class="tbh-bell-item" href="' + @json(route('picks.index')) + '"><strong>' + esc(i.title) +
                    '</strong><span>' + esc(i.plan) + ' · ' + esc(i.date) + '</span></a>').join('')
                : '<div class="tbh-bell-empty">' + esc(txt.empty) + '</div>';
        }

        const refresh = () => api(urls.list).then(render).catch(() => {});
        refresh();
        setInterval(refresh, 60000);

        // Al abrir la campana, los picks se consideran vistos
        $(document).on('shown.bs.dropdown', '#tbhBell', function () {
            api(urls.seen, 'POST').then(() => { $count.classList.add('d-none'); });
        });

        // ---------- Push ----------
        const supported = vapidKey && 'serviceWorker' in navigator && 'PushManager' in window && 'Notification' in window;
        if (!supported) { return; }

        const b64 = (key) => {
            const pad = '='.repeat((4 - key.length % 4) % 4);
            const raw = atob((key + pad).replace(/-/g, '+').replace(/_/g, '/'));
            return Uint8Array.from([...raw].map((c) => c.charCodeAt(0)));
        };
        const getSub = () => navigator.serviceWorker.register(urls.sw).then((reg) => reg.pushManager.getSubscription().then((sub) => ({ reg, sub })));

        function paint(sub) {
            $toggle.classList.remove('d-none');
            if (Notification.permission === 'denied') {
                $toggle.textContent = txt.denied; $toggle.disabled = true; return;
            }
            $toggle.disabled = false;
            $toggle.innerHTML = sub ? '<i class="fas fa-bell-slash mr-1"></i>' + esc(txt.disable) : '<i class="fas fa-bell mr-1"></i>' + esc(txt.enable);
            $toggle.dataset.on = sub ? '1' : '';
        }

        getSub().then(({ sub }) => {
            paint(sub);
            // Mantiene el servidor al día si el navegador ya tenía la suscripción
            if (sub) { api(urls.push, 'POST', sub.toJSON()); }
        }).catch(() => {});

        $toggle.addEventListener('click', async (e) => {
            e.stopPropagation();
            const { reg, sub } = await getSub();
            if (sub) {
                await api(urls.push, 'DELETE', { endpoint: sub.endpoint });
                await sub.unsubscribe();
                return paint(null);
            }
            if (await Notification.requestPermission() !== 'granted') { return paint(null); }
            const created = await reg.pushManager.subscribe({ userVisibleOnly: true, applicationServerKey: b64(vapidKey) });
            await api(urls.push, 'POST', created.toJSON());
            paint(created);
            if (window.toastr) { toastr.success(txt.enabled); }
        });
    });
</script>
