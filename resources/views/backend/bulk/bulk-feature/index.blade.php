@extends('backend.layouts.master')
@section('title','Manage Bulk Featured Products')
@section('main-content')
@push('styles')
@endpush
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Manage Bulk Featured Products</h4>
                    <a href="{{ route('bulk-featured-products.create') }}" class="btn btn-sm btn-primary">
                        Add New Product
                    </a>
                </div>
                <div class="card-body">                   
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>MRP</th>
                                    <th>Bulk Rate</th>
                                    <th>Min Qty</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bulkFeaturedProducts as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->title ?? 'N/A' }}</td>
                                    <td>₹{{ number_format($item->product->lowestMrpInventory->mrp ?? 0) }}</td>
                                    <td>₹{{ number_format($item->bulk_rate, 2) }}</td>
                                    <td>{{ $item->min_qty }} pcs</td>
                                    <td>
                                        @if ($item->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('bulk-featured-products.edit', $item->id) }}"
                                            class="btn btn-sm btn-icon btn-warning">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('bulk-featured-products.destroy', $item->id) }}" method="POST" class="d-inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No bulk featured products found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="my-pagination mt-2 mb-2">
                        {{ $bulkFeaturedProducts->links('vendor.pagination.bootstrap-4') }}
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
@endpush