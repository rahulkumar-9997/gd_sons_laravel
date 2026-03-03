@extends('backend.layouts.master')
@section('title', 'Manage Related Product')
@section('main-content')
@push('styles')
<style>
    .related-products-list {
        max-height: 150px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .related-products-list::-webkit-scrollbar {
        width: 5px;
    }

    .related-products-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .related-products-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }
</style>
@endpush

<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Related Product List</h4>
                    <a href="{{ route('manage-related-product.create') }}" data-title="Add Related Product"
                        data-bs-toggle="tooltip" title="Add Related Product" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Add Related Product
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                $mainProduct = $rows->first()->product ?? null;
                                $relationType = $rows->first()->relation_type ?? 'related';
                                $badgeClass = match($relationType) {
                                'upsell' => 'bg-warning',
                                'crossell' => 'bg-info',
                                'similar' => 'bg-success',
                                default => 'bg-secondary'
                                };
                                @endphp

                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>
                                        @if($mainProduct)
                                        <strong>{{ $mainProduct->title }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="ti ti-hash"></i> ID: {{ $mainProduct->id }}
                                        </small>
                                        <br>
                                        <small class="text-info">
                                            <i class="ti ti-tag"></i> Variant: {{ $variantId }}
                                        </small>
                                        @else
                                        <span class="text-danger">
                                            <i class="ti ti-alert-circle"></i> Product not found
                                        </span>
                                        <br>
                                        <small class="text-muted">Variant: {{ $variantId }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="related-products-list">
                                            @forelse($rows as $row)
                                            <div class="mb-1 p-1 border-bottom">
                                                @if($row->product)
                                                <i class="ti ti-checkbox text-success me-1"></i>
                                                {{ $row->product->title }}
                                                <small class="text-muted">(ID: {{ $row->product_id }})</small>
                                                @else
                                                <i class="ti ti-alert-circle text-danger me-1"></i>
                                                <span class="text-danger">Product deleted</span>
                                                <small class="text-muted">(ID: {{ $row->product_id }})</small>
                                                @endif
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
                                            <div class="mb-1">
                                                <i class="ti ti-edit text-primary me-1"></i>
                                                {{ $row->title }}
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <span class="text-muted">
                                            <i class="ti ti-minus"></i> No custom titles
                                        </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('manage-related-product.edit', $variantId) }}"
                                                class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Edit Group">
                                                <i class="ti ti-pencil"></i>
                                            </a>

                                            <form action="{{ route('manage-related-product.destroy', $variantId) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="tooltip" title="Delete Group"
                                                    onclick="return confirm('Are you sure you want to delete this entire related product group? This action cannot be undone.')">
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

                    <div class="d-flex justify-content-center mt-3">
                        {{ $variants->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="ti ti-packages" style="font-size: 48px; color: #ccc;"></i>
                        <h5 class="mt-3">No Related Products Found</h5>
                        <p class="text-muted">Start by adding your first related product group.</p>
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

@endpush