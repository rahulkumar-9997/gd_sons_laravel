@extends('backend.layouts.master')
@section('title','Manage Bulk Order Page')
@section('main-content')
@push('styles')
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Manage Bulk Order Page</h4>
                    <a href="{{ route('supplies.create') }}"
                        data-title="Add Supply"
                        data-bs-toggle="tooltip"
                        title="Add new Supply"
                        class="btn btn-sm btn-primary">
                        Add new Supply
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Buyer</th>
                                    <th>Place</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($supplies as $supply)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $supply->title }}</td>
                                    <td>{{ $supply->buyer }}</td>
                                    <td>{{ $supply->place }}</td>
                                    <td>{{ $supply->products_count }}</td>
                                    <td>
                                        @if ($supply->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('supplies.edit', $supply->id) }}"
                                            data-bs-toggle="tooltip" title="Edit"
                                            class="btn btn-sm btn-icon btn-warning">
                                            <i class="fadeIn animated bx bx-edit-alt"></i>
                                        </a>

                                        <form action="{{ route('supplies.destroy', $supply->id) }}" method="POST" class="d-inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this supply?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                data-bs-toggle="tooltip" title="Delete"
                                                class="btn btn-sm btn-icon btn-danger">
                                                <i class="fadeIn animated bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No supplies found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $supplies->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Container Fluid -->
<!-- Modal -->
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')
@endpush