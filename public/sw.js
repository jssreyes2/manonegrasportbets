// Service worker de La Mano Negra: solo gestiona las notificaciones push de los picks.
self.addEventListener('install', () => self.skipWaiting());
self.addEventListener('activate', (event) => event.waitUntil(self.clients.claim()));

self.addEventListener('push', (event) => {
    let data = {};
    try { data = event.data ? event.data.json() : {}; } catch (e) { data = {}; }

    event.waitUntil(self.registration.showNotification(data.title || 'La Mano Negra', {
        body: data.body || '',
        icon: '/img/logo.ico',
        tag: data.tag || 'pick',
        renotify: true,
        data: { url: data.url || '/my-home' },
    }));
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = (event.notification.data && event.notification.data.url) || '/my-home';

    event.waitUntil(self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((list) => {
        for (const client of list) {
            if ('focus' in client) {
                client.navigate(url);
                return client.focus();
            }
        }
        return self.clients.openWindow(url);
    }));
});
