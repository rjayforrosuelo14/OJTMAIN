const CACHE_NAME = 'ojt-management-v1';
const OFFLINE_URL = '/';

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll([
            OFFLINE_URL,
            '/ojt-logo.jpg',
            '/icons/icon-192.png',
            '/icons/icon-512.png'
        ]))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => Promise.all(
            keys
                .filter((key) => key !== CACHE_NAME)
                .map((key) => caches.delete(key))
        ))
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                const responseCopy = response.clone();
                caches.open(CACHE_NAME).then((cache) => cache.put(event.request, responseCopy));
                return response;
            })
            .catch(() => caches.match(event.request).then((cached) => cached || caches.match(OFFLINE_URL)))
    );
});
