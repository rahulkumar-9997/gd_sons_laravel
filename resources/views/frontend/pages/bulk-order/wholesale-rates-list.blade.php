@extends('frontend.layouts.master')

@section('title','Wholesale Rate List | Bulk Kitchen Appliances & Cookware — GD Sons Varanasi')
@section('description', 'Wholesale rate list for pressure cookers, cookware, chimneys, gas stoves, bottles and dinner sets. Minimum quantities and bulk rates against MRP. GST invoice, pan-India delivery from Varanasi.')

@section('main-content')
<div class="bulk-page bg-background-main text-textcolor-primary">
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('bulk.order') }}">Bulk Order</a></li>
                                <li class="breadcrumb-item active">Wholesale Rates</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full relative pt-0 overflow-hidden bg-gradient-to-b from-white via-background-light to-primary-mint/70 border-b border-primary-mint">
        <div class="absolute inset-0 pointer-events-none"
            style="background-image:radial-gradient(circle,#0F8B8D 1px,transparent 1px);background-size:24px 24px;opacity:.07;"></div>
        <div class="absolute pointer-events-none"
            style="top:-6rem;right:-6rem;width:420px;height:420px;border-radius:9999px;background:rgba(26,166,165,.14);filter:blur(90px);"></div>

        <div class="container-fluid-lg relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start py-10 lg:py-14">
                <div class="lg:col-span-7">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-8 h-px bg-primary-teal"></span>
                        <span class="text-[11.5px] font-bold uppercase tracking-[0.18em] text-primary-teal">
                            Bulk &amp; wholesale
                        </span>
                    </div>
                    <h1 class="text-[28px] sm:text-[34px] lg:text-[38px] font-bold text-primary-navy leading-[1.12] tracking-tight">
                        Wholesale rate list
                    </h1>
                    <p class="text-[16px] text-textcolor-secondary leading-[1.75] mt-4 max-w-[62ch]">
                        Per-piece rates on our most-ordered kitchen products, quoted at the minimum
                        quantity shown against each item. Send us the list you need and we confirm
                        final rates with GST and delivery in writing — usually the same working day.
                    </p>
                    <ul class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-5">
                        @foreach ([
                            'Authorised dealer',
                            'Serving Varanasi since 1970',
                            'GST invoice on every order',
                        ] as $fact)
                            <li class="flex items-center gap-2 text-[13.5px] text-textcolor-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" class="text-primary-teal shrink-0">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                                {{ $fact }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex flex-wrap items-center gap-3 mt-7">
                        <a href="{{ route('bulk.order') }}#form"
                        class="group inline-flex items-center gap-3 rounded-lg bg-primary-teal px-6 py-3.5 text-[12px] font-bold uppercase tracking-[0.12em] text-white shadow-sm hover:bg-primary-navy transition-colors duration-300">
                            Request a quotation
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform">
                                <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>

                        <a href="https://wa.me/919935070000?text=Hello%2C%20I%20want%20wholesale%20rates%20for%20a%20kitchen%20order."
                        target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2.5 rounded-lg border border-primary-teal/30 bg-white px-6 py-3.5 text-[12px] font-bold uppercase tracking-[0.12em] text-primary-teal shadow-sm hover:bg-primary-mint transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8z"></path>
                            </svg>
                            Send list on WhatsApp
                        </a>
                    </div>
                </div>

                {{-- ── right: terms at a glance + bulk desk ── --}}
                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-primary-mint bg-white shadow-lg shadow-primary-navy/5 overflow-hidden">

                        <div class="px-5 py-3.5 bg-background-light border-b border-primary-mint">
                            <p class="text-[10.5px] font-bold uppercase tracking-[0.16em] text-textcolor-light">
                                Terms at a glance
                            </p>
                        </div>

                        <ul class="px-5 py-2">
                            @foreach ([
                                ['Rates shown',      'Per piece, GST extra'],
                                ['Minimum quantity', 'As listed on each product'],
                                ['Above minimum',    'Priced sharper than shown'],
                                ['Quotation',        'Within one working day'],
                                ['Delivery',         'Pan-India, freight at actuals'],
                            ] as [$label, $value])
                                <li class="flex items-center justify-between gap-4 py-3 border-b border-primary-mint last:border-b-0">
                                    <span class="text-[13.5px] text-textcolor-secondary">{{ $label }}</span>
                                    <span class="text-[13.5px] font-semibold text-textcolor-primary text-right">{{ $value }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- bulk desk --}}
                        <div class="px-5 py-4 bg-background-light border-t border-primary-mint">
                            <p class="text-[10.5px] font-bold uppercase tracking-[0.16em] text-textcolor-light mb-2.5">
                                Bulk desk
                            </p>

                            <a href="tel:+919935070000"
                            class="flex items-center gap-3 text-primary-navy hover:text-primary-teal transition-colors">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary-mint text-primary-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-[15px] font-bold leading-tight">+91 99350 70000</span>
                                    <span class="block text-[12.5px] text-textcolor-secondary mt-0.5">Mon–Sat, 11:00 AM – 8:30 PM</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="w-full pb-10">
        <div class="container-fluid-lg">
            @php
                $list     = $bulkProducts ?? collect();
                $noImage  = asset('frontend/assets/gd-img/product/no-image.png');
                $bestSave = collect($list)->max(fn ($p) => (int) ($p['save'] ?? 0)) ?: 0;
            @endphp
            <div class="flex items-end justify-between gap-4 mb-4">
                <h2 class="text-[20px] md:text-[24px] font-bold text-primary-navy leading-tight">Rate sheet</h2>                
            </div>
            @if (count($list))
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3.5">
                    @foreach ($list as $p)
                        @php
                            $name  = $p['name']  ?? '';
                            $brand = $p['brand'] ?? '';
                            $url   = $p['url']   ?? '#';
                            $mrp   = (float) ($p['mrp']  ?? 0);
                            $rate  = (float) ($p['rate'] ?? 0);
                            $min   = (int)   ($p['min']  ?? 10);
                            $save  = (int)   ($p['save'] ?? 0);
                            $best  = $save > 0 && $save === $bestSave;
                        @endphp
                        <article class="group relative flex flex-col rounded-2xl border border-primary-mint bg-background-card p-3.5 transition-all duration-300 hover:border-primary-teal hover:shadow-lg hover:shadow-primary-teal/10 hover:-translate-y-0.5">
                            @if ($best)
                                <span class="absolute -top-2 right-4 inline-flex items-center gap-1 rounded-full bg-emerald-600 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.2 6.6 1-4.8 4.7 1.1 6.6L12 17.4 6.2 20.5l1.1-6.6L2.5 9.2l6.6-1z"/></svg>
                                    Best saving
                                </span>
                            @endif
                            <div class="flex items-start gap-3.5">
                                <a href="{{ $url }}"
                                   class="relative shrink-0 w-[76px] h-[76px] rounded-xl bg-background-light border border-primary-mint flex items-center justify-center overflow-hidden">
                                    <img src="{{ $p['image'] ?? $noImage }}"
                                         alt="{{ trim($brand.' '.$name) }}"
                                         loading="lazy" width="76" height="76"
                                         onerror="this.onerror=null;this.src='{{ $noImage }}';"
                                         class="max-w-[82%] max-h-[82%] object-contain transition-transform duration-300 group-hover:scale-110">
                                    @if ($save > 0)
                                        <span class="absolute bottom-0 inset-x-0 bg-emerald-600 py-0.5 text-center text-[10px] font-bold text-white tabular-nums">
                                            −{{ $save }}%
                                        </span>
                                    @endif
                                </a>
                                <div class="min-w-0 flex-1">
                                    @if ($brand)
                                        <p class="text-[10.5px] font-bold uppercase tracking-[0.12em] text-primary-teal">{{ $brand }}</p>
                                    @endif
                                    <a href="{{ $url }}" title="{{ $name }}"
                                       class="block text-[14px] font-semibold text-textcolor-primary leading-snug mt-0.5 truncate group-hover:text-primary-teal transition-colors">
                                        {{ $name }}
                                    </a>
                                    <div class="flex items-baseline gap-2 mt-2">
                                        <span class="font-serif text-[21px] font-bold text-primary-navy leading-none tabular-nums">₹{{ number_format($rate) }}</span>
                                        <span class="text-[10.5px] text-textcolor-light">per pc</span>
                                        @if ($save > 0 && $mrp > 0)
                                            <del class="ml-auto text-[12px] text-textcolor-light tabular-nums">₹{{ number_format($mrp) }}</del>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3.5 pt-3 border-t border-primary-mint flex items-center justify-between gap-3">
                                <span class="inline-flex items-center gap-1.5 text-[12px] font-semibold text-textcolor-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" class="text-primary-teal shrink-0">
                                        <path d="m7.5 4.27 9 5.15"></path>
                                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                        <path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path>
                                    </svg>
                                    Min. <span class="text-primary-navy font-bold tabular-nums">{{ $min }}</span> pcs
                                </span>
                                <a href="{{ route('bulk.order') }}#form"
                                   class="inline-flex items-center gap-1.5 rounded-lg border border-primary-teal/40 px-3.5 py-2 text-[11px] font-bold uppercase tracking-[0.1em] text-primary-teal hover:bg-primary-teal hover:text-white hover:border-primary-teal transition-colors duration-200">
                                    Enquire
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>               
            @else
                <div class="rounded-2xl border border-primary-mint bg-background-card px-6 py-16 text-center">
                    <span class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-background-light text-primary-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m7.5 4.27 9 5.15"></path>
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                            <path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path>
                        </svg>
                    </span>
                    <p class="font-serif text-[20px] font-bold text-primary-navy">Rate sheet is being updated</p>
                    <p class="text-[14.5px] text-textcolor-secondary mt-2 max-w-[46ch] mx-auto leading-relaxed">
                        Send us your requirement and we will quote against your list directly.
                    </p>
                    <a href="{{ route('bulk.order') }}#form"
                       class="inline-flex items-center gap-2 mt-6 rounded-lg bg-primary-teal px-6 py-3.5 text-[12px] font-bold uppercase tracking-[0.12em] text-white hover:bg-primary-navy transition-colors">
                        Ask for a quote
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section class="w-full pb-12">
        <div class="container-fluid-lg">
            <div class="rounded-2xl border border-primary-mint bg-primary-mint px-6 py-8 md:px-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-[21px] md:text-[25px] font-bold text-primary-navy leading-tight">
                        Need something not on this sheet?
                    </h2>
                    <p class="text-[15px] text-textcolor-secondary leading-relaxed mt-2 max-w-[56ch]">
                        Around 5,000 products sit in the shop and more can be arranged from our
                        distributors. Send the whole list — we quote it together.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="{{ route('bulk.order') }}#form"
                       class="rounded-lg bg-primary-teal px-6 py-3.5 text-[12px] font-bold uppercase tracking-[0.12em] text-white hover:bg-primary-navy transition-colors">
                        Get a bulk quote
                    </a>
                    <a href="tel:+919935070000"
                       class="rounded-lg border border-primary-teal/40 bg-white px-6 py-3.5 text-[12px] font-bold uppercase tracking-[0.12em] text-primary-teal hover:bg-white/60 transition-colors">
                        Call 99350 70000
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
@endpush