@php
$title = ucwords(strtolower($product['title']));
@endphp
<a href="{{ $product['url'] }}" data-id="{{ $product['id'] }}" title="{{ $title }}"
    class="rt-wagon group flex h-[60px] w-[190px] flex-none snap-start items-center gap-2 rounded-xl border border-[#e6ecec] bg-white py-[5px] pl-[5px] pr-2.5 no-underline shadow-sm transition-shadow duration-300 hover:shadow-lg">
    <span class="flex h-12 w-12 flex-none items-center justify-center overflow-hidden rounded-[9px] bg-[#f5f7f7]">
        <img src="{{ $product['image'] }}" alt="{{ $title }}" width="48" height="48" loading="lazy" decoding="async"
            class="h-full w-full object-contain p-[3px] transition-transform duration-300 group-hover:scale-110"
            onerror="this.onerror=null;this.src='https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png'">
    </span>
    <span class="rt-name min-w-0 flex-auto line-clamp-2 whitespace-normal break-words text-[13px] font-medium leading-4 text-primary-navy">
        {{ $title }}
    </span>
</a>