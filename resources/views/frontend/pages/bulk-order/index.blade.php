@extends('frontend.layouts.master')

@section('title','Bulk Orders | Wholesale Kitchen Appliances & Cookware — GD Sons Varanasi')
@section('description', 'Bulk and wholesale rates on pressure cookers, cookware, chimneys, gas stoves, bottles and dinner sets for hotels, offices, weddings and institutions. Authorised dealer, GST invoice, pan-India delivery. Quote within 24 hours.')
@section('main-content')
<style>
    .bulk-page h1,
    .bulk-page h2,
    .bulk-page h3,
    .bulk-page h4,
    .bulk-page p {
        margin: 0;
    }

    .bulk-page ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .bulk-page a {
        text-decoration: none;
    }

    .bulk-page details>summary {
        list-style: none;
    }

    .bulk-page details>summary::-webkit-details-marker {
        display: none;
    }

    .bulk-page .chip span {
        display: block;
        cursor: pointer;
        border: 1px solid #DFF4F2;
        background: #fff;
        border-radius: 9999px;
        padding: .5rem .9rem;
        font-size: 13px;
        line-height: 1.2;
        text-align: center;
        transition: background-color .2s, color .2s, border-color .2s;
    }

    .bulk-page .chip span:hover {
        border-color: #0F8B8D;
    }

    .bulk-page .chip input:checked+span {
        background: #0F8B8D;
        color: #fff;
        border-color: #0F8B8D;
    }

    @media (prefers-reduced-motion: reduce) {
        .bulk-page * {
            transition-duration: .01ms !important;
            animation-duration: .01ms !important;
        }
    }
</style>
<div class="bulk-page bg-background-main text-textcolor-primary">
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active">Bulk Order</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full relative pt-0 pb-10">
        <div class="container-fluid-lg">
            <div class="relative overflow-hidden rounded-3xl bg-primary-navy px-6 sm:px-10 lg:px-14 pt-12 pb-10 lg:pt-16 lg:pb-16">
                <div class="relative grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">
                    <div class="lg:col-span-7">
                        <div class="flex flex-wrap items-center gap-2 mb-7">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-3.5 py-1.5 text-[11.5px] font-semibold uppercase tracking-[0.14em] text-white/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-cyan"></span>
                                Since 1970 · Sigra, Varanasi
                            </span>
                            <span class="inline-flex items-center rounded-full bg-white/10 border border-white/15 px-3.5 py-1.5 text-[11.5px] font-semibold uppercase tracking-[0.14em] text-white/80">
                                Authorised dealer
                            </span>
                        </div>

                        <h1 class="font-bold text-white text-[34px] sm:text-[42px] lg:text-[45px] leading-[1.05] tracking-tight mb-3">
                            Bulk <span class="text-primary-cyan italic font-medium">Orders</span>,<br class="hidden sm:block">
                            priced for your quantity.
                        </h1>

                        <p class="mt-6 max-w-[56ch] text-[16px] sm:text-[17px] leading-relaxed text-white/75">
                            Hotels, offices, weddings, hostels and shops buy their kitchen in one go
                            from us. Send your list — a written quote comes back within a working day.
                        </p>

                        @php
                        $points = [
                        ['title' => 'Genuine brands, full warranty', 'detail' => 'Hawkins, Prestige, Milton, Borosil, Sujata, Sunflame and 20 more'],
                        ['title' => 'GST invoice, every time', 'detail' => 'Billed to your firm so input credit is claimable'],
                        ['title' => 'Delivered and installed', 'detail' => 'Pan-India dispatch · chimneys and hobs fitted in Varanasi'],
                        ];
                        @endphp
                        <div class="mt-9 grid gap-3 sm:grid-cols-3">
                            @foreach ($points as $point)
                            <div class="rounded-xl border border-white/10 bg-white/[0.07] p-4 transition-colors duration-300 hover:bg-white/[0.11]">
                                <p class="text-[16px] font-semibold leading-snug text-white">{{ $point['title'] }}</p>
                                <p class="mt-1 text-[14px] leading-relaxed text-white/60">{{ $point['detail'] }}</p>
                            </div>
                            @endforeach
                        </div>

                        <div class="flex flex-wrap items-center gap-3 mt-9">
                            <a href="#form"
                                class="group rounded-xl inline-flex items-center gap-3 px-4 py-3 bg-white text-primary-navy text-[11.5px] font-bold uppercase tracking-[0.15em] hover:bg-primary-mint transition-all duration-300 hover:-translate-y-0.5">
                                Get a bulk quote
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                            <a href="https://wa.me/919935070000?text=Hello%2C%20I%20want%20bulk%20pricing%20for%20a%20kitchen%20order."
                                target="_blank" rel="noopener"
                                class="rounded-xl inline-flex items-center gap-2.5 px-4 py-3 border border-white/25 text-white text-[11.5px] font-bold uppercase tracking-[0.15em] hover:bg-white/10 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8z"></path>
                                </svg>
                                WhatsApp 99350 70000
                            </a>
                        </div>
                        @php
                        $stats = [
                        ['value' => '55+', 'label' => 'Years in Varanasi'],
                        ['value' => '25+', 'label' => 'Brands stocked'],
                        ['value' => '24 hrs', 'label' => 'Quote turnaround'],
                        ['value' => '4.8', 'label' => 'Rated on Google', 'star' => true],
                        ];
                        @endphp
                        <div class="mt-5 pt-5 border-t border-white/10">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-5">
                                @foreach ($stats as $stat)
                                <div class="{{ !$loop->first ? 'sm:border-l sm:border-white/10 sm:pl-6' : '' }}">
                                    <div class="flex items-baseline gap-1.5 mb-1">
                                        <p class="font-serif text-[26px] font-bold text-white">{{ $stat['value'] }}</p>
                                        @if (!empty($stat['star']))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-amber-400 -translate-y-0.5">
                                            <path d="M12 2l2.9 6.2 6.6 1-4.8 4.7 1.1 6.6L12 17.4 6.2 20.5l1.1-6.6L2.5 9.2l6.6-1z" />
                                        </svg>
                                        @endif
                                    </div>
                                    <p class="text-[11.5px] uppercase tracking-widest text-white/50 mt-1.5">{{ $stat['label'] }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 relative">
                        <div class="relative mx-auto max-w-sm lg:max-w-none">
                            <div class="rounded-2xl bg-background-card shadow-2xl overflow-hidden">
                                <div class="px-6 py-3 bg-background-light border-b border-primary-mint">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-[12px] font-bold uppercase tracking-[0.16em] text-textcolor-light">Sample item · Hawkins 5L Cooker</p>
                                            <p class="font-serif text-[19px] font-bold text-primary-navy leading-tight mt-1">Your price drops as you order more</p>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $tiers = [
                                ['qty' => '1 – 9 pcs', 'label' => 'Retail', 'price' => '₹1,899', 'save' => null, 'active' => false],
                                ['qty' => '10 – 24 pcs', 'label' => 'Bulk-I', 'price' => '₹1,720', 'save' => 'Save 9%', 'active' => false],
                                ['qty' => '25 – 49 pcs', 'label' => 'Bulk-II', 'price' => '₹1,610', 'save' => 'Save 15%', 'active' => true],
                                ['qty' => '50+ pcs', 'label' => 'Wholesale', 'price' => '₹1,485', 'save' => 'Save 22%', 'active' => false],
                                ];
                                @endphp
                                <div class="divide-y divide-primary-mint">
                                    @foreach ($tiers as $t)
                                    <div class="flex items-center justify-between gap-3 px-6 py-4 {{ $t['active'] ? 'bg-primary-teal/[0.06]' : '' }}">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <span class="shrink-0 w-9 h-9 rounded-lg flex items-center justify-center text-[11px] font-bold {{ $t['active'] ? 'bg-primary-teal text-white' : 'bg-background-light text-textcolor-light' }}">
                                                {{ $loop->iteration }}
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-[14px] font-semibold text-textcolor-primary leading-tight">{{ $t['qty'] }}</p>
                                                <p class="text-[12px] text-textcolor-light mt-0.5">{{ $t['label'] }} pricing{{ $t['active'] ? ' · most ordered' : '' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <p class="font-serif text-[17px] font-bold {{ $t['active'] ? 'text-primary-teal' : 'text-primary-navy' }} leading-none">{{ $t['price'] }}</p>
                                            @if ($t['save'])
                                            <p class="text-[11px] font-semibold text-emerald-600 mt-1">{{ $t['save'] }}</p>
                                            @else
                                            <p class="text-[11px] text-textcolor-light mt-1">per piece</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="px-6 py-4 bg-background-light border-t border-primary-mint">
                                    <p class="text-[12.5px] text-textcolor-secondary leading-relaxed">
                                        <span class="font-semibold text-primary-navy">Same tier structure applies</span> across cookware, chimneys, hobs and gifting items — mix products, quantities combine.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full pt-0 relative bg-gradient-to-br from-white via-background-light to-primary-mint">
        <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(circle,#0F8B8D_1px,transparent_1px)] bg-[length:22px_22px]"></div>
        <div class="container-fluid-lg">
            <div class="w-full lg:py-10 md:py-8 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-primary-navy leading-[1.1] tracking-tight mb-2">
                            Who We <span class="text-primary-teal italic font-medium">Serve</span>
                        </h2>
                        <p class="text-[16px] text-textcolor-secondary mb-3 leading-relaxed">
                            Every buyer needs something different from a bulk order, so the quote changes too
                        </p>
                        @php
                        $segments = [
                        [
                        'gradient' => 'from-amber-100 to-amber-50',
                        'hover' => 'hover:border-amber-300/50',
                        'icon_tone' => 'text-amber-600',
                        'icon' => '
                        <path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"></path>
                        <line x1="6" y1="17" x2="18" y2="17"></line>
                        ',
                        'title' => 'Hotels, Restaurants & Caterers',
                        'body' => 'Commercial-size cookers, kadhais, gas ranges and serving ware — the sizes home stores skip, plus spares kept in stock for you.',
                        ],

                        [
                        'gradient' => 'from-blue-100 to-blue-50',
                        'hover' => 'hover:border-blue-300/50',
                        'icon_tone' => 'text-blue-600',
                        'icon' => '
                        <rect x="3" y="8" width="18" height="4" rx="1"></rect>
                        <path d="M12 8v13"></path>
                        <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
                        <path d="M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8s1-5 4.5-5a2.5 2.5 0 0 1 0 5"></path>
                        ',
                        'title' => 'Corporate & Festive Gifting',
                        'body' => 'Diwali hampers, joining kits and long-service gifts. Flasks, tiffins and casseroles, laser engraved with your logo.',
                        ],

                        [
                        'gradient' => 'from-rose-100 to-rose-50',
                        'hover' => 'hover:border-rose-300/50',
                        'icon_tone' => 'text-rose-600',
                        'icon' => '
                        <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path>
                        ',
                        'title' => 'Weddings & Family Functions',
                        'body' => '101 and 111 piece kandaal and thali sets, return gifts for guests, and a full kitchen for the new home — quoted together.',
                        ],

                        [
                        'gradient' => 'from-emerald-100 to-emerald-50',
                        'hover' => 'hover:border-emerald-300/50',
                        'icon_tone' => 'text-emerald-600',
                        'icon' => '
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        ',
                        'title' => 'Schools, Hostels & Institutions',
                        'body' => 'Mess kitchens, canteens and guest houses. Quotation on letterhead for your PO, same specification on every reorder.',
                        ],

                        [
                        'gradient' => 'from-violet-100 to-violet-50',
                        'hover' => 'hover:border-violet-300/50',
                        'icon_tone' => 'text-violet-600',
                        'icon' => '
                        <path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5"></path>
                        <path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244"></path>
                        <path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05"></path>
                        ',
                        'title' => 'Builders, Interiors & Resellers',
                        'body' => 'Hobs and chimneys in project quantities, delivered tower by tower, installed by our own technicians. Shop stock at dealer rates.',
                        ],
                        ];
                        @endphp

                        <div class="space-y-4">
                            @foreach ($segments as $segment)
                            <div class="group rounded-xl border border-transparent bg-gradient-to-br p-3 transition-all duration-300 hover:shadow-lg {{ $segment['gradient'] }} {{ $segment['hover'] }}">
                                <div class="flex items-start gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/70 {{ $segment['icon_tone'] }}">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="22"
                                            height="22"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            {!! $segment['icon'] !!}
                                        </svg>
                                    </span>
                                    <div>
                                        <h3 class="mb-1 text-[18px] font-semibold text-textcolor-primary md:text-[20px]">
                                            {{ $segment['title'] }}
                                        </h3>
                                        <p class="text-[16px] text-textcolor-secondary">
                                            {{ $segment['body'] }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="form">
                        <div class="bg-background-card rounded-2xl shadow-2xl p-6 sm:p-8 border border-primary-mint sticky top-24">
                            <h3 class="text-2xl font-semibold text-primary-navy leading-[1.1] tracking-tight mb-2">
                                Bulk <span class="text-primary-teal italic font-medium">Order</span>
                            </h3>
                            <p class="text-[14px] text-textcolor-secondary leading-relaxed mb-6">
                                Tell us what you need — our team gets in touch with rates within one working day.
                            </p>

                            @if (session('bulk_success'))
                            <div class="mb-5 rounded-lg bg-primary-mint px-4 py-3 text-[13.5px] text-primary-navy">
                                {{ session('bulk_success') }}
                            </div>
                            @endif

                            <form id="bulkForm" method="POST" action="" novalidate>
                                @csrf

                                {{-- honeypot --}}
                                <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="hidden" value="">

                                <!-- Order details -->
                                <p class="mb-2.5 text-[12.5px] font-semibold uppercase tracking-wider text-textcolor-secondary">Order details</p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <input id="f-budget" name="budget" type="text" inputmode="numeric" value="{{ old('budget') }}"
                                            placeholder="Budget (₹) *"
                                            class="w-full rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] placeholder:text-textcolor-light focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">
                                        <p class="err hidden mt-1.5 text-[12px] text-red-600"></p>
                                        @error('budget')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <input id="f-qty" name="quantity" type="text" value="{{ old('quantity') }}"
                                            placeholder="Quantity *"
                                            class="w-full rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] placeholder:text-textcolor-light focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">
                                        <p class="err hidden mt-1.5 text-[12px] text-red-600"></p>
                                        @error('quantity')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="f-date" class="block text-[11.5px] font-medium text-textcolor-light mb-1.5">Expected date of delivery</label>
                                        <input id="f-date" name="delivery_date" type="date" value="{{ old('delivery_date') }}"
                                            class="w-full rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] text-textcolor-primary focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">
                                        @error('delivery_date')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-[11.5px] font-medium text-textcolor-light mb-1.5">Gift wrapped</label>
                                        <div class="flex gap-2">
                                            @foreach (['Yes', 'No'] as $opt)
                                            <label class="chip flex-1 text-center">
                                                <input type="radio" name="gift_wrapped" value="{{ $opt }}" class="sr-only" @checked(old('gift_wrapped')===$opt)>
                                                <span>{{ $opt }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        @error('gift_wrapped')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <textarea id="f-req" name="requirement" rows="4"
                                        placeholder="Describe in detail — items, sizes, brands, quantities — e.g. 40 x Hawkins 5L steel, 6 x Sunflame 90cm chimney"
                                        class="w-full resize-y rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] placeholder:text-textcolor-light focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">{{ old('requirement') }}</textarea>
                                    <p class="err hidden mt-1.5 text-[12px] text-red-600"></p>
                                    @error('requirement')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <!-- Contact details -->
                                <p class="mt-6 mb-2.5 text-[12.5px] font-semibold uppercase tracking-wider text-textcolor-secondary">Contact details</p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <input id="f-name" name="name" type="text" value="{{ old('name') }}" placeholder="Contact person *"
                                            class="w-full rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] placeholder:text-textcolor-light focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">
                                        <p class="err hidden mt-1.5 text-[12px] text-red-600"></p>
                                        @error('name')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <input id="f-phone" name="phone" type="tel" inputmode="numeric" maxlength="10"
                                            value="{{ old('phone') }}" placeholder="Phone number *"
                                            class="w-full rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] placeholder:text-textcolor-light focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">
                                        <p class="err hidden mt-1.5 text-[12px] text-red-600"></p>
                                        @error('phone')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <input id="f-email" name="email" type="email" value="{{ old('email') }}" placeholder="Email *"
                                            class="w-full rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] placeholder:text-textcolor-light focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">
                                        <p class="err hidden mt-1.5 text-[12px] text-red-600"></p>
                                        @error('email')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <input id="f-location" name="location" type="text" value="{{ old('location') }}" placeholder="Location *"
                                            class="w-full rounded-lg border border-primary-mint bg-white px-4 py-3.5 text-[13.5px] placeholder:text-textcolor-light focus:border-primary-teal focus:ring-2 focus:ring-primary-teal/10 focus:outline-none transition-all">
                                        <p class="err hidden mt-1.5 text-[12px] text-red-600"></p>
                                        @error('location')<p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-primary-teal text-white text-[12px] font-bold uppercase tracking-[0.12em] px-6 py-3.5 hover:bg-primary-navy hover:-translate-y-0.5 transition-all duration-200">
                                        Send Enquiry
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="m12 5 7 7-7 7"></path>
                                        </svg>
                                    </button>
                                    <a id="waSend" href="https://wa.me/919935070000" target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-2 rounded-lg border border-primary-teal/30 text-primary-teal text-[12px] font-bold uppercase tracking-[0.12em] px-6 py-3.5 hover:bg-primary-mint transition-all duration-200">
                                        Send on WhatsApp
                                    </a>
                                </div>

                                <p id="formStatus" role="status" class="mt-4 hidden rounded-lg px-4 py-3 text-[13.5px]"></p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════ RECENTLY SUPPLIED IN BULK ══════════════ -->
    <section class="w-full relative bg-background-main pt-0 overflow-hidden">
        <div class="container-fluid-lg relative">
            <div class="w-full lg:py-20 md:py-14 py-10">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">
                    <div class="max-w-2xl">
                        <h2 class="text-[2rem] md:text-[2.6rem] font-bold text-primary-navy leading-[1.1] tracking-tight mb-4">
                            Recently Supplied in
                            <span class="relative inline-block text-primary-teal italic font-medium">
                                Bulk
                                <svg class="absolute -bottom-1.5 left-0 w-full" height="6" viewBox="0 0 120 6" fill="none" preserveAspectRatio="none">
                                    <path d="M2 4C30 1.5 60 1.5 118 3.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" opacity="0.4" />
                                </svg>
                            </span>
                        </h2>
                        <p class="text-[16px] text-textcolor-secondary leading-relaxed">
                            A curated sample of orders dispatched from our Sigra store — what was bought,
                            how many, and where it went.
                        </p>
                    </div>
                    <a href="#form"
                        class="group relative shrink-0 inline-flex items-center gap-3 rounded-full bg-primary-navy pl-7 pr-2 py-2 text-[12px] font-bold uppercase tracking-[0.14em] text-white shadow-xl shadow-primary-navy/20 hover:shadow-primary-navy/30 transition-all duration-300 overflow-hidden">
                        <span class="absolute inset-0 bg-gradient-to-r from-primary-teal to-primary-teal/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                        <span class="relative z-10">Get your quote</span>
                        <span class="relative z-10 inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/15 group-hover:bg-white/25 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-0.5">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </span>
                    </a>
                </div>
                @php
                $supplies = [
                [
                'category' => 'Pressure Cookers',
                'buyer' => 'Hotel kitchen',
                'place' => 'Lanka, Varanasi',
                'month' => 'Aug 2026',
                'accent' => 'teal',
                'badge' => 'bg-primary-teal/10 text-primary-teal',
                'bar' => 'from-primary-teal to-primary-teal/30',
                'dot' => 'bg-primary-teal',
                'items' => [
                ['qty' => 40, 'unit' => 'pcs', 'name' => 'Hawkins Contura 5 L Steel'],
                ],
                ],
                [
                'category' => 'Full Kitchen Fit-out',
                'buyer' => 'Banquet hall',
                'place' => 'Sarnath',
                'month' => 'Jul 2026',
                'accent' => 'blue',
                'badge' => 'bg-blue-50 text-blue-700',
                'bar' => 'from-blue-500 to-blue-400/30',
                'dot' => 'bg-blue-500',
                'items' => [
                ['qty' => 6, 'unit' => 'units', 'name' => 'Sunflame Chimney 90 cm BLDC'],
                ['qty' => 12, 'unit' => 'pcs', 'name' => 'Futura Big Boy Handi 8 L'],
                ['qty' => 200, 'unit' => 'pcs', 'name' => 'Steel Tumblers 300 ml'],
                ],
                ],
                [
                'category' => 'Corporate Gifting',
                'buyer' => 'Diwali employee gifting',
                'place' => 'Bhelupur, Varanasi',
                'month' => 'Oct 2025',
                'accent' => 'amber',
                'badge' => 'bg-amber-50 text-amber-700',
                'bar' => 'from-amber-500 to-amber-400/30',
                'dot' => 'bg-amber-500',
                'items' => [
                ['qty' => 150, 'unit' => 'pcs', 'name' => 'Milton Vacuum Flask 750 ml'],
                ],
                ],
                [
                'category' => 'Institutional',
                'buyer' => 'Hostel mess kitchen',
                'place' => 'Ramnagar',
                'month' => 'Jun 2026',
                'accent' => 'emerald',
                'badge' => 'bg-emerald-50 text-emerald-700',
                'bar' => 'from-emerald-500 to-emerald-400/30',
                'dot' => 'bg-emerald-500',
                'items' => [
                ['qty' => 400, 'unit' => 'pcs', 'name' => 'Steel Tumblers 300 ml'],
                ['qty' => 180, 'unit' => 'pcs', 'name' => 'Steel Thali 12 inch'],
                ['qty' => 8, 'unit' => 'pcs', 'name' => 'Big Boy Handi 12 L'],
                ],
                ],
                [
                'category' => 'Mixers & Juicers',
                'buyer' => 'Sweet shop chain',
                'place' => 'Chowk, Varanasi',
                'month' => 'May 2026',
                'accent' => 'violet',
                'badge' => 'bg-violet-50 text-violet-700',
                'bar' => 'from-violet-500 to-violet-400/30',
                'dot' => 'bg-violet-500',
                'items' => [
                ['qty' => 18, 'unit' => 'units', 'name' => 'Sujata Dynamix 900 W Mixer'],
                ],
                ],
                [
                'category' => 'Wedding',
                'buyer' => 'Family function',
                'place' => 'Sigra, Varanasi',
                'month' => 'Apr 2026',
                'accent' => 'rose',
                'badge' => 'bg-rose-50 text-rose-700',
                'bar' => 'from-rose-500 to-rose-400/30',
                'dot' => 'bg-rose-500',
                'items' => [
                ['qty' => 3, 'unit' => 'sets', 'name' => 'Neelam 111 Pc Kandaal Set'],
                ['qty' => 60, 'unit' => 'pcs', 'name' => 'Cello Casserole 2.5 L'],
                ],
                ],
                ];
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($supplies as $s)
                    @php
                    $items = $s['items'];
                    $count = count($items);
                    $single = $count === 1;
                    $total = array_sum(array_column($items, 'qty'));
                    @endphp

                    <article class="group relative flex flex-col rounded-2xl bg-white border border-slate-200/70 p-4 shadow-[0_1px_2px_rgba(15,23,42,0.04)] hover:shadow-[0_16px_36px_-12px_rgba(15,139,141,0.22)] hover:border-primary-teal/25 hover:-translate-y-1 transition-all duration-400 ease-out overflow-hidden">
                        <div class="absolute top-4 bottom-4 left-0 w-[3px] rounded-r-full bg-gradient-to-b {{ $s['bar'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-400"></div>
                        <div class="flex items-center justify-between gap-2 mb-3 pl-1.5">
                            <span class="inline-flex items-center gap-1.5 rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-[0.1em] {{ $s['badge'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
                                {!! $s['category'] !!}
                            </span>
                            <span class="text-[10.5px] font-semibold text-slate-400 tabular-nums">{{ $s['month'] }}</span>
                        </div>
                        <div class="flex items-end gap-2 pl-1.5 mb-3">
                            <span class="font-serif text-[34px] font-bold text-primary-navy leading-[0.9] tabular-nums tracking-[-0.02em]">{{ number_format($single ? $items[0]['qty'] : $total) }}</span>
                            <div class="flex flex-col pb-0.5">
                                <span class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400 leading-tight">{{ $single ? $items[0]['unit'] : 'pieces' }}</span>
                                @if (!$single)
                                <span class="text-[10px] font-semibold text-primary-teal leading-tight">{{ $count }} SKUs</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 pl-1.5">
                            @if ($single)
                            <p class="text-[13px] font-semibold text-slate-700 leading-snug line-clamp-2">
                                {{ $items[0]['name'] }}
                            </p>
                            @else
                            <ul class="space-y-1.5">
                                @foreach (array_slice($items, 0, 2) as $item)
                                <li class="flex items-center gap-2">
                                    <span class="shrink-0 text-[10.5px] font-bold text-primary-navy tabular-nums bg-slate-50 rounded px-1.5 py-0.5 ring-1 ring-slate-200/70">
                                        {{ $item['qty'] }} {{ $item['unit'] }}
                                    </span>
                                    <span class="text-[12px] text-slate-500 leading-snug truncate">{{ $item['name'] }}</span>
                                </li>
                                @endforeach
                                @if ($count > 2)
                                <li class="text-[11px] font-semibold text-primary-teal pl-1 pt-0.5">
                                    + {{ $count - 2 }} more item{{ $count - 2 > 1 ? 's' : '' }}
                                </li>
                                @endif
                            </ul>
                            @endif
                        </div>

                        <!-- ── Footer: Buyer + Place ── -->
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2 pl-1.5">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary-teal shrink-0">
                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span class="text-[12px] font-semibold text-slate-700 truncate">{{ $s['place'] }}</span>
                            </div>
                            <span class="text-[11px] text-slate-400 truncate shrink-0 max-w-[40%] text-right">{{ $s['buyer'] }}</span>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="w-full relative bg-background-card">
        <div class="absolute inset-0 pointer-events-none opacity-10 bg-[radial-gradient(circle,#0F8B8D_1px,transparent_1px)] bg-[length:22px_22px]"></div>
        <div class="container-fluid-lg">
            <div class="w-full lg:py-10 md:py-14 py-10">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-14 items-start">
                    <div class="sticky top-24">
                        <h2 class="text-3xl md:text-4xl font-bold text-primary-navy leading-[1.1] tracking-tight mb-3">
                            Why <span class="text-primary-teal italic font-medium">GD Sons</span>
                        </h2>
                        <p class="text-[16px] text-textcolor-secondary leading-relaxed">
                            Girdhar Das &amp; Sons has been the kitchen store of Varanasi since 1970 — trusted
                            by home cooks, hotels and professional chefs alike.
                        </p>
                        <a href="{{ route('about-us') }}"
                            class="inline-flex items-center gap-2 mt-6 text-[13px] font-bold uppercase tracking-[0.12em] text-primary-teal hover:text-primary-navy transition-colors">
                            More about us
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ([
                        ['Authorised dealer, real warranty', 'Everything comes through official channels, serviceable at brand centres anywhere in India. No grey stock.'],
                        ['Try it before you order fifty', 'Come to Sigra, run the mixer, feel the weight of the kadhai. At this quantity a photo hides too much.'],
                        ['Spares stay available', 'Gaskets, safety valves, handles and mixer jars for what you bought — years later, not only in warranty.'],
                        ['One person owns your order', 'A name and a number, not a ticket queue — from quote to dispatch to anything afterwards.'],
                        ] as [$t, $b])
                        <div class="rounded-xl p-5 bg-background-light border border-primary-mint">
                            <h3 class="font-serif text-[19px] font-bold text-textcolor-primary mb-1.5">{{ $t }}</h3>
                            <p class="text-[14.5px] text-textcolor-secondary leading-relaxed">{{ $b }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full relative bg-background-main pb-5">
        <div class="absolute inset-0 pointer-events-none"
            style="background-image:radial-gradient(circle,#0F8B8D 1px,transparent 1px);background-size:22px 22px;opacity:.07;"></div>       

        <div class="container-fluid-lg relative">
            <div class="w-full lg:py-14 md:py-10 py-8">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

                    <!-- ── left: heading + help card ── -->
                    <div class="lg:col-span-4">
                        <div class="lg:sticky lg:top-24">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="w-8 h-px bg-primary-teal"></span>
                                <span class="text-[11.5px] font-semibold uppercase tracking-[0.18em] text-primary-teal">Before you enquire</span>
                            </div>

                            <h2 class="text-2xl md:text-3xl font-bold text-primary-navy leading-[1.15] tracking-tight mb-4">
                                Common <span class="text-primary-teal italic font-medium">Questions</span>
                            </h2>

                            <p class="text-[15.5px] text-textcolor-secondary leading-relaxed">
                                The six things bulk buyers ask us most — minimums, billing, warranty,
                                delivery, customisation and terms.
                            </p>

                            <!-- help card -->
                            <div class="mt-8 rounded-2xl overflow-hidden" style="background:linear-gradient(135deg,#062B45 0%,#0F8B8D 100%);">
                                <div class="p-6">
                                    <span class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background:rgba(255,255,255,.15);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
                                            <path d="M9.5 9a2.5 2.5 0 1 1 3.4 2.3c-.6.3-.9.9-.9 1.5v.2"></path>
                                            <path d="M12 17h.01"></path>
                                        </svg>
                                    </span>
                                    <h3 class="font-serif text-[19px] font-bold text-white leading-tight">
                                        Question not answered here?
                                    </h3>
                                    <p class="text-[14px] text-white/75 leading-relaxed mt-2">
                                        Call the bulk desk and speak to someone who handles these orders daily.
                                    </p>

                                    <div class="mt-5 space-y-2.5">
                                        <a href="tel:+919935070000"
                                            class="flex items-center gap-3 rounded-lg bg-white px-4 py-3 text-primary-navy hover:bg-primary-mint transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                            </svg>
                                            <span class="text-[13.5px] font-bold">+91 99350 70000</span>
                                        </a>

                                        <a href="https://wa.me/919935070000?text=Hello%2C%20I%20have%20a%20question%20about%20bulk%20orders."
                                            target="_blank" rel="noopener"
                                            class="flex items-center gap-3 rounded-lg px-4 py-3 text-white transition-colors duration-300"
                                            style="border:1px solid rgba(255,255,255,.3);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8z"></path>
                                            </svg>
                                            <span class="text-[13.5px] font-bold">Ask on WhatsApp</span>
                                        </a>
                                    </div>

                                    <p class="text-[12px] text-white/55 mt-4">Mon–Sat, 11:00 AM – 8:30 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── right: accordion ── -->
                    <div class="lg:col-span-8">

                        @php
                        $faqs = [
                        [
                        'cat' => 'Minimum order',
                        'icon' => '
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8 8h6a3 3 0 0 1 0 6H8h8" />
                        <path d="M8 11h7" />
                        <path d="M11 14v4" />',
                        'q' => 'How many pieces before I get bulk pricing?',
                        'a' => 'There is no fixed minimum. As a rough guide the rate changes once you cross about ten units of one item, or ₹25,000 across the order. Categories count together, so cookers plus tumblers plus a chimney is still one bulk order.',
                        ],
                        [
                        'cat' => 'Billing & GST',
                        'icon' => '
                        <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z" />
                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                        <path d="M12 17.5v-11" />',
                        'q' => 'Will I get a GST invoice?',
                        'a' => 'Yes — billed to your firm with your GSTIN so input credit is claimable, plus an e-way bill where the consignment value needs one. Share the GSTIN with your enquiry and it will already be on the quotation.',
                        ],
                        [
                        'cat' => 'Warranty',
                        'icon' => '
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                        <path d="m9 12 2 2 4-4" />',
                        'q' => 'Is the warranty the same as buying a single piece?',
                        'a' => 'Exactly the same. We are authorised dealers, so each appliance carries its manufacturer warranty and is serviceable at brand service centres anywhere in India.',
                        ],
                        [
                        'cat' => 'Delivery',
                        'icon' => '
                        <path d="M10 17h4V5H2v12h3" />
                        <path d="M20 17h2v-3.34a4 4 0 0 0-1.17-2.83L19 9h-5v8h1" />
                        <circle cx="7.5" cy="17.5" r="2.5" />
                        <circle cx="17.5" cy="17.5" r="2.5" />',
                        'q' => 'Can you deliver outside Varanasi?',
                        'a' => 'Yes, across India by courier or transporter depending on size, with freight shown separately on the quote. Within Varanasi our own team delivers, and chimneys and hobs are installed by our technicians.',
                        ],
                        [
                        'cat' => 'Customisation',
                        'icon' => '
                        <rect x="3" y="8" width="18" height="4" rx="1" />
                        <path d="M12 8v13" />
                        <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" />
                        <path d="M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8s1-5 4.5-5a2.5 2.5 0 0 1 0 5" />',
                        'q' => 'Can products be engraved or gift-packed?',
                        'a' => 'Bottles, tiffins, casseroles and dinner sets can be laser engraved or supplied in printed boxes carrying your logo, above a working quantity. Send the logo file with your enquiry and we will confirm what is possible.',
                        ],
                        [
                        'cat' => 'Payment & returns',
                        'icon' => '
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                        <path d="M14 2v5h6" />
                        <path d="M9 13h6" />
                        <path d="M9 17h4" />',
                        'q' => 'What about payment terms and returns?',
                        'a' => 'An advance against the proforma invoice, balance before dispatch; registered firms with a repeat history can discuss credit terms. Transit damage reported with photos within 48 hours is replaced. Engraved and specially ordered items cannot be returned.',
                        ],
                        ];
                        @endphp

                        <div class="space-y-3">
                            @foreach ($faqs as $i => $faq)
                            <details class="group rounded-xl bg-background-card border border-primary-mint shadow-sm open:border-primary-teal/60 open:shadow-md transition-all duration-300"
                                @if ($i===0) open @endif>

                                <summary class="flex cursor-pointer items-start gap-4 px-5 py-4 list-none">

                                    <!-- icon -->
                                    <span class="w-10 h-10 shrink-0 rounded-lg flex items-center justify-center bg-background-light text-primary-teal group-open:bg-primary-teal group-open:text-white transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $faq['icon'] !!}</svg>
                                    </span>

                                    <span class="min-w-0 flex-1">
                                        <span class="block text-[10.5px] font-bold uppercase tracking-[0.14em] text-textcolor-light">{{ $faq['cat'] }}</span>
                                        <span class="block font-serif text-[17px] md:text-[18px] font-bold text-textcolor-primary leading-snug mt-1 group-hover:text-primary-teal group-open:text-primary-navy transition-colors duration-300">
                                            {{ $faq['q'] }}
                                        </span>
                                    </span>

                                    <!-- toggle -->
                                    <span class="w-8 h-8 shrink-0 rounded-full flex items-center justify-center border border-primary-mint text-primary-teal group-open:bg-primary-teal group-open:border-primary-teal group-open:text-white transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"
                                            class="group-open:rotate-45 transition-transform duration-300">
                                            <path d="M12 5v14"></path>
                                            <path d="M5 12h14"></path>
                                        </svg>
                                    </span>
                                </summary>

                                <div class="faq-answer px-5 pb-5 pl-[76px]">
                                    <p class="text-[15px] leading-[1.8] text-textcolor-secondary">{{ $faq['a'] }}</p>
                                </div>
                            </details>
                            @endforeach
                        </div>

                        <!-- nudge to the form -->
                        <div class="mt-4 rounded-xl border border-primary-mint bg-background-light px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <p class="text-[14.5px] text-textcolor-secondary">
                                Ready with your list? Rates come back the same working day.
                            </p>
                            <a href="#form"
                                class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-primary-teal px-5 py-3 text-[12px] font-bold uppercase tracking-[0.12em] text-white hover:bg-primary-navy transition-colors duration-300">
                                Get a bulk quote
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')

@endpush