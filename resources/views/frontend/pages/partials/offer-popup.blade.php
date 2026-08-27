@if($activeOfferPopup)
<div id="offerPopupOverlay" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 p-4">
    <div id="offerPopupBox" class="relative w-full max-w-[300px] sm:max-w-[380px] md:max-w-[440px] scale-90 opacity-0 transition-all duration-300 ease-out">
        <button type="button" id="offerPopupClose" aria-label="Close offer"
            class="absolute -top-3 -right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-[#0F8B8D] text-2xl leading-none text-white shadow-lg transition hover:bg-[#0c7072]">
            &times;
        </button>

        @if($activeOfferPopup->redirect_url)<a href="{{ $activeOfferPopup->redirect_url }}" class="block">@endif
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('storage/images/offer/'.$activeOfferPopup->mobile_image) }}">
                <img src="{{ asset('storage/images/offer/'.$activeOfferPopup->desktop_image) }}"
                    alt="{{ $activeOfferPopup->title ?? 'Special Offer' }}"
                    class="block w-full h-auto rounded-2xl shadow-2xl">
            </picture>
            @if($activeOfferPopup->redirect_url)
        </a>@endif
    </div>
</div>

<button type="button" id="offerStickyBtn" aria-label="Show offers"
    class="offer-sticky-pulse fixed right-0 top-1/2 z-[9998] flex items-center gap-2 rounded-l-full bg-[#0F8B8D] py-3 pl-4 pr-3 sm:pl-5 sm:pr-4 text-sm font-semibold text-white shadow-lg transition-colors hover:bg-[#0c7072]">
    <span>Offers</span>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
    </svg>
</button>
<style>
    @keyframes offerStickyPulse {
        0%, 100% { transform: translateY(-50%) scale(1); }
        50%      { transform: translateY(-50%) scale(1.08); }
    }
    .offer-sticky-pulse { animation: offerStickyPulse 1.1s ease-in-out 3; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const overlay   = document.getElementById('offerPopupOverlay');
    const box       = document.getElementById('offerPopupBox');
    const closeBtn  = document.getElementById('offerPopupClose');
    const stickyBtn = document.getElementById('offerStickyBtn');

    const OFFER_ID     = {{ $activeOfferPopup->id }};
    const COOKIE_NAME  = 'gdsons_offer_dismissed';
    const DISMISS_MS   = 24 * 60 * 60 * 1000;
    const AUTO_HIDE_MS = 10000;  
    let autoHideTimer = null;
    function getDismissedMap() {
        const match = document.cookie.match(/(?:^|; )gdsons_offer_dismissed=([^;]*)/);
        if (!match) return {};
        const map = {};
        match[1].split('_').forEach(function (pair) {
            const parts = pair.split('-');
            if (parts.length === 2) {
                map[parts[0]] = parseInt(parts[1], 10);
            }
        });
        return map;
    }

    function isOfferDismissed(id) {
        const map = getDismissedMap();
        const dismissedAt = map[id];
        return !!dismissedAt && (Date.now() - dismissedAt) <= DISMISS_MS;
    }
    function rememberDismissal(id) {
        const map = getDismissedMap();
        const now = Date.now();
        Object.keys(map).forEach(function (key) {
            if (now - map[key] > DISMISS_MS) delete map[key];
        });
        map[id] = now;
        const value = Object.keys(map).map(function (key) {
            return key + '-' + map[key];
        }).join('_');
        document.cookie = COOKIE_NAME + '=' + value + '; max-age=' + (DISMISS_MS / 1000) + '; path=/; SameSite=Lax';
    }
    function openPopup() {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        requestAnimationFrame(function () {
            box.classList.remove('opacity-0', 'scale-90');
            box.classList.add('opacity-100', 'scale-100');
        });
        autoHideTimer = setTimeout(function () {
            closePopup(true);
        }, AUTO_HIDE_MS);
    }
    function closePopup(remember) {
        if (autoHideTimer) {
            clearTimeout(autoHideTimer);
            autoHideTimer = null;
        }
        box.classList.remove('opacity-100', 'scale-100');
        box.classList.add('opacity-0', 'scale-90');
        setTimeout(function () {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }, 300);

        if (remember) {
            rememberDismissal(OFFER_ID);
        }
    }
    if (!isOfferDismissed(OFFER_ID)) {
        setTimeout(openPopup, 800);
    }
    closeBtn.addEventListener('click', function () { closePopup(true); });
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closePopup(true);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !overlay.classList.contains('hidden')) closePopup(true);
    });
    stickyBtn.addEventListener('click', function () { openPopup(); });
});
</script>
@endif