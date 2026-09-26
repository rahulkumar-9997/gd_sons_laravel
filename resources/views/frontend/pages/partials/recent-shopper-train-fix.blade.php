<div id="recent-train" data-feed="{{ route('recent-train.feed') }}" role="region" aria-label="Recently viewed products"
     class="hidden fixed inset-x-0 bottom-0 z-40 translate-y-full transition-transform duration-500 ease-out">
    <button type="button" id="rt-toggle" aria-expanded="true"
            class="absolute bottom-full left-3 sm:left-4 flex items-center gap-1.5 sm:gap-2 rounded-t-xl border-0 bg-primary-teal px-3 sm:px-3.5 py-1.5 text-[11px] sm:text-xs font-semibold text-white shadow-[0_-4px_12px_rgba(6,43,69,0.2)] cursor-pointer">
            <span class="relative flex h-2 w-2">
                <span class="absolute inset-0 inline-flex animate-ping rounded-full bg-white opacity-70"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-white"></span>
            </span>        
        Recently Viewed by Shoppers        
        <svg id="rt-chevron" xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div class="bg-gradient-to-br from-[#0e687c] via-primary-teal to-primary-cyan shadow-[0_-8px_24px_rgba(6,43,69,0.25)]">
        <div class="h-[3px] bg-white/20">
            <div id="rt-progress" class="h-full w-0 bg-white"></div>
        </div>

        <div class="container-fluid-lg">
            <div id="rt-row" class="flex items-center gap-2 sm:gap-3 py-1.5 sm:py-2">
                <div id="rt-thumbs"
                     class="hidden flex-none min-w-0 flex-row-reverse items-center justify-start gap-2 overflow-hidden border-r border-white/35 pr-3.5"></div>
                <div id="rt-viewport"
                     class="min-w-0 flex-1 overflow-x-hidden overflow-y-hidden touch-pan-y snap-x snap-mandatory [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden [-webkit-mask-image:linear-gradient(90deg,#000_90%,transparent_100%)] [mask-image:linear-gradient(90deg,#000_90%,transparent_100%)]">
                    <div id="rt-track" class="flex gap-2.5 py-0.5"></div>
                </div>
            </div>
        </div>
    </div>
</div>