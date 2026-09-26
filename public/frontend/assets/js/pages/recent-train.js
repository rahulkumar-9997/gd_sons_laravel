(function () {
    var root = document.getElementById('recent-train');
    if (!root) return;
    var feedUrl  = root.dataset.feed;
    var row      = document.getElementById('rt-row');
    var viewport = document.getElementById('rt-viewport');
    var track    = document.getElementById('rt-track');
    var thumbsEl = document.getElementById('rt-thumbs');
    var progress = document.getElementById('rt-progress');
    var toggle   = document.getElementById('rt-toggle');
    var chevron  = document.getElementById('rt-chevron');
    var ROTATE = 10000, POLL = 5000, GAP = 10;
    var SAFE_RIGHT = 90;
    var version = 0, items = [], ids = [], history = [];
    var nextPage = 0, historyDone = true, moreLoading = false;
    var batchSize = 3, step = 200, cardWidth = 190, iconMode = false, split = false;
    var ICON = 70, ICON_GAP = 8, iconCount = 6;
    var passed = [];
    var pos = 0;
    var loaded = false, loading = false, isOpen = false;
    var programmatic = false, progTimer = null;
    var elapsed = 0, last = 0;

    viewport.style.overflowX = 'hidden';
    viewport.style.touchAction = 'pan-y';

    function realCards() { return track.querySelectorAll('.rt-wagon:not(.rt-clone)'); }
    function canLoop() { return items.length > batchSize; }

    function jumpTo(index) {
        programmatic = true;
        viewport.style.scrollSnapType = 'none';
        viewport.scrollLeft = index * step;
        requestAnimationFrame(function () {
            viewport.style.scrollSnapType = 'x mandatory';
            programmatic = false;
        });
    }
    function glideTo(index, done) {
        programmatic = true;
        clearTimeout(progTimer);
        viewport.scrollTo({ left: index * step, behavior: 'smooth' });
        progTimer = setTimeout(function () {
            programmatic = false;
            if (done) done();
        }, 800);
    }

    function rebuildClones() {
        var old = track.querySelectorAll('.rt-clone');
        var cards = realCards();
        if (!canLoop() || !cards.length) {
            old.forEach(function (c) { c.parentNode.removeChild(c); });
            return;
        }
        var need = batchSize + Math.ceil(viewport.clientWidth / step) + 1;
        var frag = document.createDocumentFragment();
        for (var i = 0; i < need; i++) {
            var c = cards[i % cards.length].cloneNode(true);
            c.classList.add('rt-clone');
            c.setAttribute('aria-hidden', 'true');
            c.tabIndex = -1;
            c.style.opacity = '1';
            c.style.transform = 'none';
            c.style.boxShadow = '';
            styleCard(c);
            frag.appendChild(c);
        }
        track.appendChild(frag);
        old.forEach(function (c) { c.parentNode.removeChild(c); });
    }

    function styleCard(c) {
        var name = c.querySelector('.rt-name');
        var box  = c.querySelector('span');
        c.style.width = cardWidth + 'px';
        if (iconMode) {
            c.style.height = cardWidth + 'px';
            c.style.justifyContent = 'center';
            c.style.padding = '3px';
            if (box) { box.style.width = box.style.height = (cardWidth - 8) + 'px'; }
            if (name) name.style.display = 'none';
        } else {
            c.style.height = '';
            c.style.justifyContent = '';
            c.style.padding = '';
            if (box) { box.style.width = box.style.height = ''; }
            if (name) name.style.display = '';
        }
    }

    function layout() {
        var w = window.innerWidth;
        row.style.paddingRight = (w >= 768 ? SAFE_RIGHT : 0) + 'px';
        split = w >= 768;
        thumbsEl.style.display = (split && passed.length) ? 'flex' : 'none';
        iconCount = w >= 1280 ? 6 : w >= 1024 ? 5 : 4;
        thumbsEl.style.width = (iconCount * ICON + (iconCount - 1) * ICON_GAP + 16) + 'px';

        iconMode = w < 640;
        GAP = iconMode ? 6 : 10;
        track.style.gap = GAP + 'px';
        var vp = viewport.clientWidth;
        if (iconMode) {
            batchSize = vp >= 400 ? 6 : 5;
            cardWidth = Math.max(40, Math.floor((vp - GAP * batchSize) / (batchSize + 0.4)));
        } else {
            var full = w >= 1280
                ? ((split && passed.length) ? 3 : 4)
                : Math.max(1, Math.min(6, Math.floor((vp + GAP) / (140 + GAP))));
            if (items.length && items.length <= full) {
                full = items.length;
                batchSize = full;
                cardWidth = Math.max(120, Math.floor((vp - GAP * (full - 1)) / full));
            } else {
                var PEEK = 0.4;
                batchSize = full;
                cardWidth = Math.max(120, Math.floor((vp - GAP * full) / (full + PEEK)));
            }
        }
        step = cardWidth + GAP;
        track.querySelectorAll('.rt-wagon').forEach(styleCard);
        rebuildClones();
        jumpTo(pos);
        renderIcons(0);
        setPad();
    }

    function renderIcons(animateCount) {
        thumbsEl.innerHTML = '';
        if (!split || !passed.length) return;

        var byId = {};
        realCards().forEach(function (c) { byId[c.dataset.id] = c; });

        var shown = 0;
        for (var k = 0; k < passed.length && shown < iconCount; k++) {
            var card = byId[passed[k]];
            if (!card) continue;
            shown++;
            var img = card.querySelector('img');

            var a = document.createElement('a');
            a.href = card.getAttribute('href');
            a.title = card.getAttribute('title') || '';
            a.className = 'block overflow-hidden bg-white shadow transition-transform duration-200 hover:scale-110';
            a.style.cssText = 'flex:0 0 ' + ICON + 'px;width:' + ICON + 'px;height:' + ICON + 'px;border-radius:12px;padding:4px;';
            a.innerHTML = '<img alt="" width="' + ICON + '" height="' + ICON + '" loading="lazy" style="width:100%;height:100%;object-fit:contain;">';
            a.firstElementChild.src = img ? img.getAttribute('src') : '';
            a.firstElementChild.alt = a.title;

            if (shown <= animateCount) {
                a.style.opacity = '0';
                a.style.transform = 'translateX(24px) scale(.8)';
                a.style.transition = 'opacity .45s ease ' + ((animateCount - shown) * 70) + 'ms, transform .45s cubic-bezier(.22,1,.36,1) ' + ((animateCount - shown) * 70) + 'ms';
                (function (el) {
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () { el.style.opacity = '1'; el.style.transform = 'none'; });
                    });
                })(a);
            }
            thumbsEl.appendChild(a);
        }
    }

    function rememberPassed(fromPos, count) {
        var n = items.length, left = [];
        for (var i = count - 1; i >= 0; i--) {
            var it = items[(fromPos + i) % n];
            if (it) left.push(String(it.id));
        }
        passed = left.concat(passed.filter(function (id) { return left.indexOf(id) < 0; })).slice(0, 12);
    }

    function forward() {
        if (!canLoop()) return;

        if (!historyDone && items.length - (pos + batchSize) <= batchSize * 2) loadMore();

        if (!historyDone && pos + batchSize >= items.length) {
            elapsed = ROTATE - 1500;
            return;
        }

        var firstTime = !passed.length;
        rememberPassed(pos, batchSize);
        if (firstTime && split) layout();
        var next = pos + batchSize;
        if (next >= items.length) {
            glideTo(items.length, function () { jumpTo(0); });
            pos = 0;
        } else {
            glideTo(next);
            pos = next;
        }
        renderIcons(batchSize);
        elapsed = 0;
    }

    function render(freshIds) {
        track.innerHTML = items.map(function (i) { return i.html; }).join('');

        realCards().forEach(function (c, i) {
            c.style.opacity = '0';
            c.style.transform = 'translateY(6px)';
            c.style.transition = 'opacity .45s ease ' + Math.min(i, 5) * 70 + 'ms, transform .45s ease ' + Math.min(i, 5) * 70 + 'ms, box-shadow .3s';
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { c.style.opacity = '1'; c.style.transform = 'none'; });
            });
            if (freshIds && freshIds.indexOf(+c.dataset.id) > -1) {
                c.style.boxShadow = '0 0 0 2px rgb(6,43,69)';
                setTimeout(function () { c.style.boxShadow = ''; }, 3500);
            }
        });

        pos = 0;
        passed = [];
        layout();
        elapsed = 0;
    }

    function moveTrain(freshIds) {
        glideTo(0);

        setTimeout(function () {
            var keep = {};
            items.forEach(function (it) { keep[it.id] = true; });
            passed = passed.filter(function (id) { return keep[id]; });
            Array.prototype.slice.call(realCards()).forEach(function (c) {
                if (!keep[+c.dataset.id]) {
                    c.style.transition = 'opacity .4s ease, width .5s ease, padding .5s ease, margin .5s ease';
                    c.style.opacity = '0';
                    c.style.width = '0px';
                    c.style.paddingLeft = c.style.paddingRight = '0px';
                    c.style.marginLeft = (-GAP) + 'px';
                    setTimeout(function () { if (c.parentNode) c.parentNode.removeChild(c); }, 520);
                }
            });
            var anchor = realCards()[0] || null;
            items.forEach(function (it) {
                if (freshIds.indexOf(it.id) < 0) return;
                var tmp = document.createElement('div');
                tmp.innerHTML = it.html.trim();
                var c = tmp.firstElementChild;

                c.style.width = '0px';
                c.style.opacity = '0';
                c.style.paddingLeft = c.style.paddingRight = '0px';
                c.style.overflow = 'hidden';
                c.style.transition = 'width .6s cubic-bezier(.22,1,.36,1), padding .6s cubic-bezier(.22,1,.36,1), opacity .5s ease .15s, box-shadow .3s';
                if (iconMode) {
                    c.style.justifyContent = 'center';
                    var nm = c.querySelector('.rt-name');
                    if (nm) nm.style.display = 'none';
                }
                track.insertBefore(c, anchor);

                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        c.style.width = cardWidth + 'px';
                        c.style.paddingLeft = c.style.paddingRight = '';
                        styleCard(c);
                        c.style.opacity = '1';
                        c.style.boxShadow = '0 0 0 2px rgb(6,43,69)';
                    });
                });
                setTimeout(function () { c.style.overflow = ''; }, 650);
                setTimeout(function () { c.style.boxShadow = ''; }, 3500);
            });

            pos = 0;
            elapsed = 0;
            setTimeout(function () { layout(); }, 700);
        }, 550);
    }

    function loadMore() {
        if (moreLoading || historyDone) return;
        moreLoading = true;

        fetch(feedUrl + '?page=' + nextPage, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function (r) { if (!r.ok) throw r; return r.json(); })
            .then(function (res) {
                var firstClone = track.querySelector('.rt-clone');

                (res.items || []).forEach(function (it) {
                    if (ids.indexOf(it.id) > -1) return;
                    history.push(it);
                    items.push(it);
                    ids.push(it.id);

                    var tmp = document.createElement('div');
                    tmp.innerHTML = it.html.trim();
                    var c = tmp.firstElementChild;
                    styleCard(c);
                    track.insertBefore(c, firstClone);
                });

                nextPage = res.next_page || 0;
                historyDone = !nextPage;
                rebuildClones();
            })
            .catch(function () { historyDone = true; })
            .finally(function () { moreLoading = false; });
    }

    function load() {
        if (loading) return;
        loading = true;

        fetch(feedUrl + '?v=' + version, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function (r) { if (!r.ok) throw r; return r.json(); })
            .then(function (res) {
                if (!res.changed) return;
                version = res.version;

                var list = res.items || [];
                if (!list.length) return;

                var fresh = loaded ? list.filter(function (i) { return ids.indexOf(i.id) < 0; }).map(function (i) { return i.id; }) : [];
                var listIds = list.map(function (i) { return i.id; });
                history = history.filter(function (h) { return listIds.indexOf(h.id) < 0; });
                items = list.concat(history);
                ids = items.map(function (i) { return i.id; });

                if (!loaded) {
                    nextPage = res.next_page || 0;
                    historyDone = !nextPage;
                    loaded = true;
                    root.style.display = 'block';
                    render();
                    setOpen(!wasHidden());
                } else if (fresh.length) {
                    if (isOpen && document.visibilityState === 'visible') moveTrain(fresh);
                    else render(fresh);
                }
            })
            .catch(function () {})
            .finally(function () { loading = false; });
    }

    setInterval(function () {
        if (!loaded || document.visibilityState !== 'visible') return;
        if (!historyDone) loadMore();
        else load();
    }, POLL);
    document.addEventListener('visibilitychange', function () {
        if (loaded && document.visibilityState === 'visible') load();
    });
    window.addEventListener('focus', function () { if (loaded) load(); });

    function wasHidden() { try { return sessionStorage.getItem('rt-hidden') === '1'; } catch (e) { return false; } }
    function remember(v) { try { sessionStorage.setItem('rt-hidden', v ? '1' : '0'); } catch (e) {} }

    function setPad() {
        document.body.style.paddingBottom = isOpen ? root.offsetHeight + 'px' : '';
    }

    function setOpen(open) {
        isOpen = open;
        root.style.transform = open ? 'translateY(0)' : 'translateY(100%)';
        chevron.style.transform = open ? '' : 'rotate(180deg)';
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        setPad();
    }

    toggle.addEventListener('click', function () { setOpen(!isOpen); remember(!isOpen); });

    var resizeTimer = null, lastWidth = window.innerWidth;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (!loaded || window.innerWidth === lastWidth) return;
            lastWidth = window.innerWidth;
            pos = Math.floor(pos / batchSize) * batchSize;
            layout();
        }, 150);
    });

    function frame(now) {
        var dt = last ? Math.min(now - last, 64) : 16;
        last = now;

        if (loaded && isOpen && document.visibilityState === 'visible' && canLoop()) {
            elapsed += dt;
            progress.style.width = Math.min(100, elapsed / ROTATE * 100) + '%';
            if (elapsed >= ROTATE) forward();
        } else if (elapsed === 0) {
            progress.style.width = '0%';
        }
        requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);

    var started = false;
    function start() { if (!started) { started = true; load(); } }
    window.addEventListener('scroll', start, { passive: true, once: true });
    if (document.readyState === 'complete') setTimeout(start, 1500);
    else window.addEventListener('load', function () { setTimeout(start, 1500); });
})();