@extends('backend.layouts.master')
@section('title', $categories->title)
@section('main-content')
@push('styles')
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        {{ $categories->title }}
                        <a href="{{route('category')}}" data-title="Go Back to Category" data-bs-toggle="tooltip" class="btn btn-sm btn-purple" data-bs-original-title="Go Back to Category">
                        << Go Back to Category
                        </a>
                    </h4>
                    <a href="{{route('additional-filter.create', $categories->id)}}" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus"></i> Add Additional Filter
                    </a>
                </div>
                <div class="card-body">
                    <table class="table align-middle mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Filter Name</th>
                                <th>Category</th>
                                <th>Attributes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($additionalFilters as $filter)
                            <tr>
                                <td>{{ $filter->id }}</td>
                                <td>
                                    {{ $filter->filter_button_name }}
                                </td>
                                <td>
                                    {{ $filter->category->title ?? '' }}
                                </td>
                                <td>
                                    @foreach($filter->filterAttributes as $filterAttribute)
                                    <div class="mb-2 border rounded p-1">
                                        <strong>
                                            {{ $filterAttribute->attribute->title ?? '' }}
                                        </strong>
                                        @foreach($filterAttribute->attributeValues as $attributeValue)
                                        <span class="badge bg-primary">
                                            {{ $attributeValue->attributeValue->name ?? '' }}
                                        </span>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('additional-filter.edit', $filter->id) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('additional-filter.delete', $filter->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this additional filter?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-delete"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No Data Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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