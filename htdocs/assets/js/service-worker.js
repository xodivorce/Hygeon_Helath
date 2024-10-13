// service-worker.js

const CACHE_NAME = 'hygeon-cache-v1';
const urlsToCache = [
    './assets/css/home.css',
    './assets/js/home.js',
    './assets/images/hygeon_heath.svg',
    './assets/videous/purple.mp4',
];

// Install the service worker and cache resources
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache);
            })
    );
});

// Fetch cached resources or fetch from the network
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
    );
});
