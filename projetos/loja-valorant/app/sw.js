// Guarda o app no celular para abrir sem internet.
// Tenta a internet primeiro (para pegar atualizações) e, sem conexão, usa a cópia guardada.
const CACHE = 'minha-loja-v1';

self.addEventListener('install', e => {
  const arquivos = [
    './', './index.html', './manifest.json', './exemplo.json',
    './icone-180.png', './icone-192.png', './icone-512.png',
    './fontes/barlow-500.woff2', './fontes/barlow-600.woff2', './fontes/barlow-condensed-700.woff2',
  ];
  e.waitUntil(caches.open(CACHE).then(c => c.addAll(arquivos)).then(() => self.skipWaiting()));
});

self.addEventListener('activate', e => e.waitUntil(self.clients.claim()));

self.addEventListener('fetch', e => {
  const endereco = new URL(e.request.url);
  // As respostas do GitHub usam a chave, então nunca entram na cópia guardada
  const podeGuardar = endereco.origin === self.location.origin || endereco.hostname === 'valorant-api.com';
  if (e.request.method !== 'GET' || !podeGuardar) return;
  e.respondWith(
    fetch(e.request)
      .then(resposta => {
        const copia = resposta.clone();
        caches.open(CACHE).then(c => c.put(e.request, copia));
        return resposta;
      })
      .catch(() => caches.match(e.request).then(r => r || (e.request.mode === 'navigate' ? caches.match('./index.html') : Response.error())))
  );
});
