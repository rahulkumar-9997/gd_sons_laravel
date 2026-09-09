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
                            ['value' => '55+',    'label' => 'Years in Varanasi'],
                            ['value' => '25+',    'label' => 'Brands stocked'],
                            ['value' => '24 hrs', 'label' => 'Quote turnaround'],
                            ['value' => '4.8',    'label' => 'Rated on Google', 'star' => true],
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

    <section class="w-full pt-0 pb-14 relative bg-gradient-to-br from-white via-background-light to-primary-mint">
        <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(circle,#0F8B8D_1px,transparent_1px)] bg-[length:22px_22px]"></div>
        <div class="container-fluid-lg">
            <div class="w-full lg:py-10 md:py-8 py-10">
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
                                            <input type="radio" name="gift_wrapped" value="{{ $opt }}" class="sr-only" @checked(old('gift_wrapped') === $opt)>
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

    <!-- ══════════════ WHAT YOU CAN ORDER ══════════════ -->
    <section class="w-full relative bg-background-card">
        <div class="absolute inset-0 pointer-events-none opacity-10 bg-[radial-gradient(circle,#0F8B8D_1px,transparent_1px)] bg-[length:22px_22px]"></div>

        <div class="w-full max-w-7xl relative mx-auto lg:py-16 md:py-12 py-10 px-4 md:px-6">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-navy leading-[1.1] tracking-tight mb-3">
                    What You Can <span class="text-primary-teal italic font-medium">Order</span>
                </h2>
                <p class="text-[16px] text-textcolor-secondary leading-relaxed">
                    Mix categories freely — everything counts towards the same bulk order
                </p>
            </div>

            @php
            $catalog = [
            ['pressure-cooker', 'Pressure Cookers', '1 L to 22 L · Hawkins, Prestige'],
            ['cookware', 'Cookware', 'Kadhai, tava, handi, triply sets'],
            ['kitchen-appliances', 'Mixers & Juicers', 'Sujata, Panasonic, Philips'],
            ['lpg-gas-stoves', 'Gas Stoves & Hobs', '1 to 4 burner, glass or steel'],
            ['chimney', 'Chimneys', '60, 75 and 90 cm · BLDC'],
            ['induction-cooktops', 'Electric Cooktops', 'Induction, infrared, rice cookers'],
            ['bottles', 'Bottles & Flasks', 'Best seller for gifting'],
            ['lunchbox-tiffin', 'Lunchbox & Tiffins', 'School, office and insulated'],
            ['dinner-sets', 'Dinner & Kandaal Sets', 'Steel, opalware, melamine'],
            ['air-fryers', 'Air Fryers', 'Philips, Borosil, Wonderchef'],
            ['cups-mugs', 'Cups, Mugs & Cutlery', 'Bone china, glass, steel'],
            ['accessories-spares', 'Spares & Accessories', 'Gaskets, valves, mixer jars'],
            ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5">
                @foreach ($catalog as [$slug, $name, $note])
                <a href="{{ url('categories/'.$slug) }}"
                    class="group rounded-xl border border-primary-mint bg-white p-4 hover:border-primary-teal/50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <span class="text-[15px] font-semibold text-textcolor-primary group-hover:text-primary-teal">{{ $name }}</span>
                    <p class="text-[13px] text-textcolor-secondary mt-1">{{ $note }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ══════════════ HOW IT WORKS ══════════════ -->
    <section class="w-full relative bg-gradient-to-b from-primary-mint to-background-main">
        <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(circle,#0F8B8D_1px,transparent_1px)] bg-[length:22px_22px]"></div>

        <div class="w-full max-w-7xl relative mx-auto lg:py-16 md:py-12 py-10 px-4 md:px-6">
            <div class="text-center max-w-2xl mx-auto mb-11">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-navy leading-[1.1] tracking-tight mb-3">
                    How It <span class="text-primary-teal italic font-medium">Works</span>
                </h2>
                <p class="text-[16px] text-textcolor-secondary leading-relaxed">From your list to your kitchen in four steps</p>
            </div>

            @php
            $steps = [
            ['1', 'bg-primary-mint text-primary-teal', 'Send your list', 'Use the form, or WhatsApp a photo of your handwritten list. "40 cookers, 5 litre, steel" is enough to start.'],
            ['2', 'bg-amber-100 text-amber-700', 'Written quote in 24 hrs','Item, brand, model, rate and GST on our letterhead — ready to go into your purchase file.'],
            ['3', 'bg-rose-100 text-rose-600', 'Confirm and pay', 'Advance against proforma invoice, balance before dispatch. Bank transfer, UPI or card.'],
            ['4', 'bg-emerald-100 text-emerald-700', 'Delivery & fitting', 'Dispatched with tracking anywhere in India. In Varanasi we deliver and install ourselves.'],
            ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($steps as [$n, $tone, $title, $body])
                <div class="rounded-2xl bg-background-card p-6 border border-primary-mint shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-11 h-11 rounded-full {{ $tone }} font-serif text-[20px] font-bold">{{ $n }}</span>
                    <h3 class="font-serif text-[20px] font-bold text-textcolor-primary mt-4 mb-2">{{ $title }}</h3>
                    <p class="text-[14.5px] text-textcolor-secondary leading-relaxed">{{ $body }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ══════════════ WHY US ══════════════ -->
    <section class="w-full relative bg-background-card">
        <div class="absolute inset-0 pointer-events-none opacity-10 bg-[radial-gradient(circle,#0F8B8D_1px,transparent_1px)] bg-[length:22px_22px]"></div>

        <div class="w-full max-w-7xl relative mx-auto lg:py-16 md:py-12 py-10 px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-14 items-start">
                <div>
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

            <div class="mt-12 pt-9 border-t border-primary-mint">
                <p class="text-center text-[12px] font-bold uppercase tracking-[0.2em] text-textcolor-light mb-6">Brands we can quote</p>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach (['hawkins','prestige','milton','borosil','sujata','sunflame','hindware','wonderchef','bergner','stahl','la opala','panasonic','cello','pexpo'] as $brand)
                    <a href="{{ url('search?query='.urlencode($brand)) }}"
                        class="rounded-full border border-primary-mint bg-white px-4 py-2 text-[13.5px] capitalize text-textcolor-secondary hover:border-primary-teal hover:text-primary-teal transition-colors">{{ $brand }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════ FAQ ══════════════ -->
    <section class="w-full relative bg-gradient-to-b from-background-main to-primary-mint">
        <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(circle,#0F8B8D_1px,transparent_1px)] bg-[length:22px_22px]"></div>

        <div class="w-full max-w-4xl relative mx-auto lg:py-16 md:py-12 py-10 px-4 md:px-6">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-navy leading-[1.1] tracking-tight mb-3">
                    Common <span class="text-primary-teal italic font-medium">Questions</span>
                </h2>
            </div>

            @php
            $faqs = [
            ['How many pieces before I get bulk pricing?', 'There is no fixed minimum. As a rough guide the rate changes once you cross about ten units of one item, or ₹25,000 across the order. Categories count together, so cookers plus tumblers plus a chimney is still one bulk order.'],
            ['Will I get a GST invoice?', 'Yes — billed to your firm with your GSTIN so input credit is claimable, plus an e-way bill where the consignment value needs one. Share the GSTIN with your enquiry and it will already be on the quotation.'],
            ['Is the warranty the same as buying a single piece?', 'Exactly the same. We are authorised dealers, so each appliance carries its manufacturer warranty and is serviceable at brand service centres anywhere in India.'],
            ['Can you deliver outside Varanasi?', 'Yes, across India by courier or transporter depending on size, with freight shown separately on the quote. Within Varanasi our own team delivers, and chimneys and hobs are installed by our technicians.'],
            ['Can products be engraved or gift-packed?', 'Bottles, tiffins, casseroles and dinner sets can be laser engraved or supplied in printed boxes carrying your logo, above a working quantity. Send the logo file with your enquiry and we will confirm what is possible.'],
            ['What about payment terms and returns?', 'An advance against the proforma invoice, balance before dispatch; registered firms with a repeat history can discuss credit terms. Transit damage reported with photos within 48 hours is replaced. Engraved and specially ordered items cannot be returned.'],
            ];
            @endphp

            <div class="space-y-3">
                @foreach ($faqs as [$q, $a])
                <details class="group rounded-xl bg-background-card border border-primary-mint px-5 py-4 shadow-sm">
                    <summary class="flex cursor-pointer items-center justify-between gap-6 font-serif text-[18px] font-bold text-textcolor-primary">
                        {{ $q }}
                        <span class="text-primary-teal text-[24px] leading-none transition-transform group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-[15px] leading-[1.8] text-textcolor-secondary">{{ $a }}</p>
                </details>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ══════════════ CTA ══════════════ -->
    <section class="w-full bg-primary-mint">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-6 py-14">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-navy via-primary-teal to-primary-cyan px-7 py-11 md:px-12 md:py-14">
                <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(circle,#ffffff_1px,transparent_1px)] bg-[length:22px_22px]"></div>
                <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-7 text-white">
                    <div>
                        <h2 class="font-serif text-[26px] md:text-[32px] font-bold leading-tight">Not sure of the exact models yet?</h2>
                        <p class="mt-2.5 max-w-[54ch] text-[15.5px] text-white/85 leading-relaxed">
                            Send a rough list anyway. We will come back with two or three options at
                            different price points — and you decide from there.
                        </p>
                        <p class="mt-4 text-[14.5px] text-white/70">
                            W.H. Smith School Road, Sigra, Varanasi · Mon–Sat 11 AM – 8:30 PM
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3 shrink-0">
                        <a href="#form" class="rounded-xl bg-white px-6 py-3.5 text-[12px] font-bold uppercase tracking-[0.12em] text-primary-navy hover:bg-primary-mint transition-colors">Get a quote</a>
                        <a href="tel:+919935070000" class="rounded-xl border border-white/40 px-6 py-3.5 text-[12px] font-bold uppercase tracking-[0.12em] text-white hover:bg-white/10 transition-colors">Call 99350 70000</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>{{-- /.bulk-page --}}

<script type="application/ld+json">
    {
        !!json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => 'Bulk and wholesale kitchen appliance supply',
                    'url' => url('bulk-order'),
                    'areaServed' => ['@type' => 'Country', 'name' => 'India'],
                    'provider' => [
                        '@type' => 'HomeGoodsStore',
                        'name' => 'Girdhar Das & Sons',
                        'url' => url('/'),
                        'telephone' => '+91-9935070000',
                        'email' => 'akshat@gdsons.co.in',
                        'foundingDate' => '1970',
                        'address' => [
                            '@type' => 'PostalAddress',
                            'streetAddress' => 'W.H. Smith School Road, Sigra',
                            'addressLocality' => 'Varanasi',
                            'addressRegion' => 'Uttar Pradesh',
                            'postalCode' => '221010',
                            'addressCountry' => 'IN',
                        ],
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => collect($faqs) - > map(fn($f) => [
                        '@type' => 'Question',
                        'name' => $f[0],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
                    ]) - > all(),
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!
    }
</script>

@endsection

@push('scripts')

@endpush