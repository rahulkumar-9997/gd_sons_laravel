@extends('backend.layouts.master')
@section('title', 'Manage Related Product')
@section('main-content')

@push('styles')
<style>
    .related-products-list {
        max-height: 150px;
        overflow-y: auto;
        padding-right: 5px;
        scrollbar-width: thin;
    }

    .related-products-list::-webkit-scrollbar {
        width: 5px;
    }

    .related-products-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }

    .related-products-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }

    .related-products-list::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .variant-badge {
        background: #e9ecef;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }

    .product-thumb {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 5px;
    }
    
    .table > :not(caption) > * > * {
        vertical-align: middle;
    }
</style>
@endpush

<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        <i class="ti ti-link me-2"></i>Related Product List
                    </h4>
                    <a href="{{ route('manage-related-product.create') }}" 
                       data-title="Add Related Product"
                       data-bs-toggle="tooltip" 
                       title="Add Related Product" 
                       class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Add Related Product
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-1"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(isset($groups) && count($groups) > 0)
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Main Product</th>
                                    <th width="30%">Related Products</th>
                                    <th width="10%">Relation Type</th>
                                    <th width="20%">Custom Title</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = ($variants->currentPage() - 1) * $variants->perPage() + 1;
                                @endphp

                                @foreach($groups as $variantId => $rows)
                                @php
                                $firstRow = $rows->first();
                                $mainProduct = $firstRow->product ?? null;
                                $relationType = $firstRow->relation_type ?? 'related';
                                $totalRelated = $rows->count();
                                
                                $badgeClass = match($relationType) {
                                    'upsell' => 'bg-warning',
                                    'crossell' => 'bg-info',
                                    'similar' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $i++ }}</span>
                                    </td>

                                    <td>
                                        @if($mainProduct)
                                        <div class="d-flex align-items-center">                                            
                                            <div>
                                                {{ $mainProduct->title }}
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                <i class="ti ti-tag"></i> Variant: {{ $variantId }}
                                            </span>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                <i class="ti ti-link"></i> {{ $totalRelated }} items
                                            </span>
                                        </div>
                                        @else
                                        <div class="text-danger">
                                            <i class="ti ti-alert-circle"></i> Product not found
                                        </div>
                                        <span class="badge bg-info bg-opacity-10 text-info mt-1">
                                            <i class="ti ti-tag"></i> Variant: {{ $variantId }}
                                        </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="related-products-list">
                                            @forelse($rows as $index => $row)
                                            <div class="mb-1 p-1 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                <div class="d-flex align-items-start">
                                                    <span class="me-2 text-muted small">{{ $index + 1 }}.</span>
                                                    @if($row->product)
                                                    <div>
                                                        {{ $row->product->title }}
                                                        
                                                    </div>
                                                    @else
                                                    <div>
                                                        <span class="text-danger">Product deleted</span>    
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @empty
                                            <span class="text-muted">No related products</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($relationType) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                        $customTitles = $rows->filter(function($row) {
                                            return !empty($row->title);
                                        });
                                        @endphp

                                        @if($customTitles->count() > 0)
                                        <div class="related-products-list">
                                            @foreach($customTitles as $row)
                                            <div class="mb-1 small">
                                                <i class="ti ti-edit text-primary me-1"></i>
                                                {{ $row->title }}
                                                <small class="text-muted">(ID: {{ $row->product_id }})</small>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <span class="text-muted small">
                                            <i class="ti ti-minus"></i> No custom titles
                                        </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('manage-related-product.edit', $variantId) }}"
                                               class="btn btn-sm btn-info" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Group">
                                                <i class="ti ti-pencil"></i>
                                            </a>

                                            <form action="{{ route('manage-related-product.destroy', $variantId) }}"
                                                  method="POST" 
                                                  class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger show_confirm"
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Group"
                                                        data-name="Related Product Group">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination with Info -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                       
                        <div>
                            {{ $variants->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="ti ti-packages" style="font-size: 48px; color: #ccc;"></i>
                        <h5 class="mt-3">No Related Products Found</h5>
                        <p class="text-muted mb-3">Start by adding your first related product group.</p>
                        <a href="{{ route('manage-related-product.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add Related Product
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('backend.layouts.common-modal-form')
@endsection

@push('scripts')
<script src="{{asset('backend/assets/js/pages/related-product.js')}}?v={{ env('ASSET_VERSION', '1.0.0') }}" type="text/javascript"></script>
@endpush