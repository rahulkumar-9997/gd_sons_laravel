@extends('frontend.layouts.master')
@section('title','GD Sons - Order success')
@section('description', 'GD Sons - Order success')
@section('keywords', 'GD Sons - Order success')

@section('main-content')
<style>
    /* Smooth animations and transitions */
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in-up-delay-1 { animation-delay: 0.1s; }
    .fade-in-up-delay-2 { animation-delay: 0.2s; }
    .fade-in-up-delay-3 { animation-delay: 0.3s; }
    .fade-in-up-delay-4 { animation-delay: 0.4s; }
    .fade-in-up-delay-5 { animation-delay: 0.5s; }
    
    .success-icon-wrapper {
        animation: pulse-ring 2s ease-in-out infinite;
    }
    
    @keyframes pulse-ring {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .confetti-piece {
        animation: confetti-fall linear forwards;
    }
    
    @keyframes confetti-fall {
        0% {
            transform: translateY(-10vh) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(110vh) rotate(720deg);
            opacity: 0;
        }
    }
    
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
    }
    
    .product-row {
        transition: all 0.3s ease;
    }
    
    .product-row:hover {
        background: linear-gradient(135deg, #f0fdf4, #f7fee7);
        transform: scale(1.01);
    }
    
    /* Mobile responsive tweaks */
    @media (max-width: 640px) {
        .mobile-stack {
            flex-direction: column;
            gap: 0.5rem;
        }
        .mobile-full-width {
            width: 100%;
        }
        .mobile-text-center {
            text-align: center;
        }
        .table-mobile-card {
            display: block;
            width: 100%;
        }
        .table-mobile-card tbody {
            display: block;
            width: 100%;
        }
        .table-mobile-card tr {
            display: block;
            width: 100%;
            margin-bottom: 1rem;
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .table-mobile-card td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 1px solid #f3f4f6;
        }
        .table-mobile-card td:last-child {
            border-bottom: none;
        }
        .table-mobile-card td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6b7280;
            font-size: 0.875rem;
        }
        .table-mobile-card td.product-detail-mobile {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .table-mobile-card td.product-detail-mobile::before {
            display: none;
        }
        .mobile-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }
    }
</style>

<!-- Confetti Container -->
<div id="confettiContainer" class="fixed inset-0 pointer-events-none z-50 overflow-hidden"></div>

<!-- Hero Section - Mobile First Responsive -->
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-green-50 py-12 sm:py-11 md:py-10 lg:py-15">
    <!-- Decorative Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-64 h-64 sm:w-96 sm:h-96 bg-emerald-300 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 sm:w-96 sm:h-96 bg-green-300 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>

    <div class="container mx-auto px-2 sm:px-2 relative">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Success Icon - Responsive -->
            <div class="flex justify-center mb-3 sm:mb-4 fade-in-up">
                <div class="relative success-icon-wrapper">
                    <div class="absolute inset-0 rounded-full border-4 border-emerald-300/30 animate-ping"></div>
                    <div class="relative w-20 h-20 sm:w-22 sm:h-22 md:w-22 md:h-22 bg-primary-teal rounded-full flex items-center justify-center shadow-2xl shadow-emerald-500/30">
                        <svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 w-6 h-6 sm:w-8 sm:h-8 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Headline -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-3xl font-extrabold text-gray-800 mb-2 sm:mb-3 fade-in-up fade-in-up-delay-1">
                Order Placed!
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-3 fade-in-up fade-in-up-delay-2">
                Thank you for your purchase, <span class="font-semibold text-primary-navy">GD Sons</span>
            </p>

            <!-- Order ID Badge - Responsive -->
            <div class="inline-flex flex-wrap items-center gap-2 sm:gap-3 bg-white/80 backdrop-blur-sm px-4 sm:px-6 py-2 sm:py-3 rounded-full shadow-lg border border-emerald-200/50 mb-4 fade-in-up fade-in-up-delay-3">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs sm:text-sm font-medium text-gray-600">Order ID:</span>
                <span class="text-xs sm:text-sm font-bold text-emerald-700 tracking-wider">{{ $order->order_id }}</span>
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-emerald-400 rounded-full animate-pulse"></span>
            </div>

            <!-- Action Buttons - Responsive Stack -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center mt-4 sm:mt-6 fade-in-up fade-in-up-delay-4">
                <a href="{{ route('order') }}" class="group inline-flex items-center justify-center px-4 sm:px-4 py-3 sm:py-3.5 bg-primary-teal text-white font-semibold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-105 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    View Order Details
                </a>
                <a href="{{ URL::to('') }}" class="group inline-flex items-center justify-center px-4 sm:px-4 py-3 sm:py-3.5 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-emerald-500 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Continue Shopping
                </a>
            </div>

            <!-- Trust Badges - Responsive Grid -->
            <div class="mt-6 sm:mt-8 grid grid-cols-3 sm:grid-cols-3 gap-3 sm:gap-2 max-w-2xl mx-auto fade-in-up fade-in-up-delay-5">
                <div class="flex items-center justify-center gap-2 text-xs sm:text-sm text-gray-500 bg-white/60 backdrop-blur-sm px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Secure Payment</span>
                </div>
                <div class="flex items-center justify-center gap-2 text-xs sm:text-sm text-gray-500 bg-white/60 backdrop-blur-sm px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Order Tracking</span>
                </div>
                <div class="flex items-center justify-center gap-2 text-xs sm:text-sm text-gray-500 bg-white/60 backdrop-blur-sm px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span>24/7 Support</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Order Summary Section -->
<section class="py-5 sm:py-0 md:py-10 bg-white">
    <div class="container mx-auto px-3 sm:px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 gap-3">
                <div>
                    <h2 class="text-xl sm:text-2xl md:text-2xl font-bold text-gray-800">Order Summary</h2>
                    <p class="text-sm sm:text-base text-gray-500 mt-0">Review your purchase details</p>
                </div>                
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <!-- Table Header - Mobile Responsive -->
                        <div class="px-4 sm:px-4 py-3 sm:py-5 bg-gradient-to-r from-emerald-50 to-green-50/50 border-b border-emerald-100/50 flex items-center justify-between">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">Order Items</h3>
                            </div>
                            <span class="text-[10px] sm:text-xs text-emerald-600 bg-emerald-100 px-2 sm:px-3 py-1 rounded-full font-medium hidden sm:inline-block">{{ $order->orderLines->count() }} products</span>
                        </div>
                        <div class="overflow-x-auto p-3 sm:p-4 md:p-6">
                            @if($order->orderLines->isNotEmpty())
                            <table class="w-full table-mobile-card">
                                <thead class="hidden sm:table-header-group">
                                    <tr class="border-b border-gray-100">
                                        <th class="pb-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Product</th>
                                        <th class="pb-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Price</th>
                                        <th class="pb-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Qty</th>
                                        <th class="pb-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderLines as $orderLine)
                                    <tr class="product-row border-b border-gray-50 transition-all duration-300 block sm:table-row mb-4 sm:mb-0 bg-white sm:bg-transparent rounded-xl sm:rounded-none shadow-sm sm:shadow-none">
                                        <td class="py-2 sm:py-3 product-detail-mobile block sm:table-cell" data-label="Product">
                                            <div class="flex items-center gap-3 sm:gap-4">
                                                <div class="w-12 h-12 sm:w-14 sm:h-16 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100 bg-gray-50 shadow-sm">
                                                    @if($orderLine->product->images->isNotEmpty())
                                                    <img src="{{ asset('images/product/thumb/' . $orderLine->product->images->first()->image_path) }}" class="w-full h-full object-cover" alt="{{ ucwords(strtolower($orderLine->product->title)) }}">
                                                    @else
                                                    <img src="{{ asset('images/default.png') }}" class="w-full h-full object-cover" alt="{{ ucwords(strtolower($orderLine->product->title)) }}">
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ url('products/'.$orderLine->product->slug) }}" class="font-semibold text-gray-800 hover:text-emerald-600 transition-colors text-sm sm:text-base line-clamp-2">
                                                        {{ ucwords(strtolower($orderLine->product->title)) }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 sm:py-4 text-left sm:text-center block sm:table-cell" data-label="Price">
                                            <span class="font-medium text-gray-700 text-sm sm:text-base">Rs. {{ number_format($orderLine->price, 2) }}</span>
                                        </td>
                                        <td class="py-3 sm:py-4 text-left sm:text-center block sm:table-cell" data-label="Qty">
                                            <span class="inline-flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 bg-gray-100 rounded-lg text-gray-700 font-bold text-sm border border-gray-200">
                                                {{ $orderLine->quantity }}
                                            </span>
                                        </td>
                                        <td class="py-3 sm:py-4 text-left sm:text-right block sm:table-cell" data-label="Total">
                                            <span class="font-bold text-emerald-600 text-sm sm:text-base">Rs. {{ $orderLine->quantity * $orderLine->price }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="block sm:table-row border-t-2 border-gray-200 bg-gray-50/50 rounded-xl sm:rounded-none">
                                        <td colspan="3" class="py-3 sm:py-4 text-right text-gray-600 font-medium block sm:table-cell" data-label="">
                                            <span class="sm:hidden font-semibold text-gray-600">Subtotal: </span>
                                        </td>
                                        <td class="py-3 sm:py-4 text-left sm:text-right font-semibold text-gray-800 block sm:table-cell" data-label="Subtotal">
                                            <span class="sm:hidden font-semibold text-gray-600">Subtotal: </span>
                                            Rs. {{ number_format($order->grand_total_amount + ($order->coupon_discount_amount ?? 0) - ($order->shiprocketCourier->courier_shipping_rate ?? 0), 2) }}
                                        </td>
                                    </tr>
                                    @if($order->shiprocketCourier)
                                    <tr class="block sm:table-row">
                                        <td colspan="3" class="py-2 text-right text-gray-500 text-sm block sm:table-cell" data-label="">
                                            <span class="sm:hidden font-medium text-gray-500">Shipping: </span>
                                            <span class="hidden sm:inline-flex items-center gap-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                </svg>
                                                Shipping ({{ $order->shiprocketCourier->courier_name }})
                                            </span>
                                        </td>
                                        <td class="py-2 text-left sm:text-right font-medium text-gray-700 block sm:table-cell" data-label="Shipping">
                                            <span class="sm:hidden font-medium text-gray-500">Shipping: </span>
                                            Rs. {{ number_format($order->shiprocketCourier->courier_shipping_rate, 2) }}
                                        </td>
                                    </tr>
                                    @endif
                                    @if(!empty($order->coupon_code) && $order->coupon_discount_amount > 0)
                                    <tr class="block sm:table-row">
                                        <td colspan="3" class="py-2 text-right text-gray-500 text-sm block sm:table-cell" data-label="">
                                            <span class="sm:hidden font-medium text-gray-500">Coupon: </span>
                                            <span class="hidden sm:inline-flex items-center gap-1">
                                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                                </svg>
                                                Coupon ({{ $order->coupon_code }})
                                            </span>
                                        </td>
                                        <td class="py-2 text-left sm:text-right font-medium text-red-500 block sm:table-cell" data-label="Coupon">
                                            <span class="sm:hidden font-medium text-gray-500">Coupon: </span>
                                            - Rs. {{ number_format($order->coupon_discount_amount, 2) }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr class="block sm:table-row bg-gradient-to-r from-emerald-50/80 to-green-50/80 border-t-2 border-emerald-200 rounded-xl sm:rounded-none">
                                        <td colspan="3" class="py-4 sm:py-5 text-right block sm:table-cell" data-label="">
                                            <span class="text-base sm:text-lg font-extrabold text-gray-800">Grand Total</span>
                                        </td>
                                        <td class="py-4 sm:py-5 text-left sm:text-right block sm:table-cell" data-label="Grand Total">
                                            <span class="text-lg sm:text-2xl font-black text-primary-teal">
                                                Rs. {{ number_format($order->grand_total_amount, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Responsive Cards -->
                <div class="space-y-4 sm:space-y-6">
                    <!-- Shipping Address -->
                    @if($order->shippingAddress)
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover-lift">
                        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-blue-50 to-indigo-50/50 border-b border-blue-100/50 flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm sm:text-base">Shipping Address</h4>
                        </div>
                        <div class="px-4 sm:px-6 py-3 sm:py-4">
                            <p class="text-sm sm:text-base text-gray-700 leading-relaxed font-medium">
                                {{ $order->shippingAddress->full_address }}
                                @if($order->shippingAddress->apartment)
                                , {{ $order->shippingAddress->apartment }}
                                @endif
                            </p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $order->shippingAddress->city_name }}, {{ $order->shippingAddress->state }} - {{ $order->shippingAddress->pin_code }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Billing Address -->
                    @if($order->billingAddress)
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover-lift">
                        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-purple-50 to-pink-50/50 border-b border-purple-100/50 flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center shadow-lg shadow-purple-500/20">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm sm:text-base">Billing Address</h4>
                        </div>
                        <div class="px-4 sm:px-6 py-3 sm:py-4">
                            <p class="text-sm sm:text-base text-gray-700 leading-relaxed font-medium">{{ $order->billingAddress->full_address }}</p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                {{ $order->billingAddress->city_name }}, {{ $order->billingAddress->state }} - {{ $order->billingAddress->pin_code }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Payment Method -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover-lift">
                        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-emerald-50 to-teal-50/50 border-b border-emerald-100/50 flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm sm:text-base">Payment Method</h4>
                        </div>
                        <div class="px-4 sm:px-6 py-3 sm:py-4">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 font-semibold rounded-lg text-xs sm:text-sm">
                                    {{ $order->payment_mode }}
                                </span>
                                
                            </div>
                            @if($order->pick_up_status == 'pick_up_store')
                            <div class="mt-3 sm:mt-4 bg-yellow-50 border border-yellow-200 rounded-xl px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-yellow-800 flex items-start gap-2 sm:gap-3">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <strong>Store Pickup</strong>
                                    <p class="text-[10px] sm:text-xs text-yellow-700 mt-0.5">Please collect your item from our shop.</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Help Section - Responsive -->
<!--<section class="py-8 sm:py-12 md:py-16 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <div class="container mx-auto px-3 sm:px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <div class="text-center p-4 sm:p-6 md:p-8 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center mx-auto mb-3 sm:mb-4 shadow-xl shadow-blue-500/20">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0a9 9 0 01-12.728 0m12.728 0a9 9 0 01-12.728 0m-4.243-4.243a9 9 0 010-12.728m0 0a9 9 0 0112.728 0"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-white text-base sm:text-lg md:text-xl mb-1 sm:mb-2">24/7 Support</h4>
                    <p class="text-gray-400 text-xs sm:text-sm leading-relaxed">Our team is always here to help. Reach out anytime.</p>
                    <a href="#" class="inline-block mt-3 sm:mt-4 text-emerald-400 font-semibold hover:text-emerald-300 transition-colors text-xs sm:text-sm">Contact Support →</a>
                </div>
                <div class="text-center p-4 sm:p-6 md:p-8 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center mx-auto mb-3 sm:mb-4 shadow-xl shadow-emerald-500/20">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-white text-base sm:text-lg md:text-xl mb-1 sm:mb-2">Track Order</h4>
                    <p class="text-gray-400 text-xs sm:text-sm leading-relaxed">Get real-time updates on your delivery status.</p>
                    <a href="#" class="inline-block mt-3 sm:mt-4 text-emerald-400 font-semibold hover:text-emerald-300 transition-colors text-xs sm:text-sm">Track Now →</a>
                </div>
                <div class="text-center p-4 sm:p-6 md:p-8 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center mx-auto mb-3 sm:mb-4 shadow-xl shadow-yellow-500/20">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-white text-base sm:text-lg md:text-xl mb-1 sm:mb-2">FAQs</h4>
                    <p class="text-gray-400 text-xs sm:text-sm leading-relaxed">Find answers to common questions about orders.</p>
                    <a href="#" class="inline-block mt-3 sm:mt-4 text-emerald-400 font-semibold hover:text-emerald-300 transition-colors text-xs sm:text-sm">View FAQs →</a>
                </div>
            </div>
        </div>
    </div>
</section>-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('confettiContainer');
    const colors = ['#10b981', '#34d399', '#6ee7b7', '#fbbf24', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#ec4899', '#f472b6'];

    for (let i = 0; i < 60; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti-piece';
        const size = Math.random() * 8 + 4;
        const isCircle = Math.random() > 0.5;
        confetti.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            background: ${colors[Math.floor(Math.random() * colors.length)]};
            left: ${Math.random() * 100}%;
            top: -10px;
            border-radius: ${isCircle ? '50%' : '2px'};
            animation-duration: ${Math.random() * 2 + 2}s;
            animation-delay: ${Math.random() * 2}s;
            transform: rotate(${Math.random() * 360}deg);
            pointer-events: none;
        `;
        container.appendChild(confetti);
    }

    setTimeout(() => {
        container.innerHTML = '';
    }, 5000);
});
</script>
@endsection

@push('scripts')
<script>
gtag('event', 'purchase', {
    transaction_id: "{{ $order->order_id }}",
    value: {{ $order->grand_total_amount }},
    currency: "INR",
    shipping: {{ $order->shiprocketCourier ? $order->shiprocketCourier->courier_shipping_rate : 0 }},
    payment_type: "{{ $order->payment_mode }}",
    items: [
        @foreach($order->orderLines as $orderLine)
        {
            item_id: "{{ $orderLine->product->id }}",
            item_name: "{{ str_replace('"', '', $orderLine->product->title) }}",
            price: {{ $orderLine->price }},
            quantity: {{ $orderLine->quantity }}
        }@if(!$loop->last),@endif
        @endforeach
    ]
});
</script>
@endpush