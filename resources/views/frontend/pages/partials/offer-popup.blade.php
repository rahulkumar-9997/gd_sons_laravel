@if($activeOfferPopup)
<div id="offerPopupOverlay" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 p-4">
    <div id="offerPopupBox" class="relative w-full max-w-[420px] scale-90 opacity-0 transition-all duration-300 ease-out">
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
    class="offer-sticky-pulse fixed bottom-5 left-0 z-[9998] flex items-center gap-2 rounded-r-full bg-[#0F8B8D] py-3 pl-3 pr-4 sm:pl-4 sm:pr-5 text-sm font-semibold text-white shadow-lg transition-colors hover:bg-[#0c7072]">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
    </svg>
    <span class="hidden sm:inline">Offers</span>
</button>

<style>
    @keyframes offerStickyPulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.08);
        }
    }

    /* plays 3 times on load to catch the eye, then settles — not a permanent bounce */
    .offer-sticky-pulse {
        animation: offerStickyPulse 1.1s ease-in-out 3;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('offerPopupOverlay');
        const box = document.getElementById('offerPopupBox');
        const closeBtn = document.getElementById('offerPopupClose');
        const stickyBtn = document.getElementById('offerStickyBtn');
        const DISMISS_KEY = 'gdsonsOfferPopupDismissed';

        function openPopup() {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            setTimeout(function() {
                box.classList.remove('opacity-0', 'scale-90');
                box.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closePopup(remember) {
            box.classList.remove('opacity-100', 'scale-100');
            box.classList.add('opacity-0', 'scale-90');
            setTimeout(function() {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }, 300);
            if (remember) {
                localStorage.setItem(DISMISS_KEY, '1');
            }
        }

        // Auto-open once — never again after it's been closed a first time
        if (!localStorage.getItem(DISMISS_KEY)) {
            setTimeout(openPopup, 800);
        }

        closeBtn.addEventListener('click', function() {
            closePopup(true);
        });

        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closePopup(true);
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !overlay.classList.contains('hidden')) closePopup(true);
        });

        // Sticky button always works, regardless of dismiss state
        stickyBtn.addEventListener('click', function() {
            openPopup();
        });
    });
</script>
@endif