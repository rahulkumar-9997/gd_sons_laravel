const CACHE_NAME = "gdsons-v1";

const STATIC_FILES = [
    "/"
];
self.addEventListener("install", event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(STATIC_FILES);
        })
    );
});
self.addEventListener("activate", event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.map(key => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        })
    );
    self.clients.claim();

});
self.addEventListener("fetch", event => {
    if (event.request.method !== "GET") {
        return;
    }
    event.respondWith(
        caches.match(event.request).then(cachedResponse => {
            if (cachedResponse) {
                return cachedResponse;
            }
            return fetch(event.request)
            .then(networkResponse => {
                if (
                    !networkResponse ||
                    networkResponse.status !== 200 ||
                    networkResponse.type !== "basic"
                ) {
                    return networkResponse;
                }
                const responseClone = networkResponse.clone();
                caches.open(CACHE_NAME).then(cache => {
                    cache.put(event.request, responseClone);
                });
                return networkResponse;
            })
            .catch(() => {
                return new Response("No Internet Connection", {
                    status: 503,
                    headers: {
                        "Content-Type": "text/plain"
                    }
                });
            });
        })
    );
});