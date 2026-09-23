@extends('backend.layouts.master')
@section('title','Edit Bulk Order Supply')
@section('main-content')
@push('styles')
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}">
@endpush
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Edit Supply</h4>
                    <a href="{{ route('supplies.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('supplies.update', $supply->id) }}" method="POST" id="supplyForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3 mb-2">
                            <div class="col-md-4">
                                <label class="form-label">Title / Category <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $supply->title) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Buyer</label>
                                <input type="text" name="buyer" class="form-control" value="{{ old('buyer', $supply->buyer) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Place</label>
                                <input type="text" name="place" class="form-control" value="{{ old('place', $supply->place) }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" name="status" value="1" class="form-check-input" id="status"
                                        {{ old('status', $supply->status) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="mb-3">Products Supplied</h6>
                        <table class="table table-bordered smalltext" id="productTable">
                            <tr>
                                <th style="width: 45%;">Select Product *</th>
                                <th>Unit</th>
                                <th>Qty *</th>
                                <th></th>
                            </tr>
                            @forelse ($supply->products as $item)
                            <tr>
                                <td>
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="text" name="product_name[]" class="form-control product-autocomplete"
                                                value="{{ $item->title }}" placeholder="Type product name" required>
                                            <span class="input-group-text">
                                                <i class="ti ti-refresh"></i>
                                                <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </span>
                                        </div>
                                        <input type="hidden" name="product_id[]" class="product_id" value="{{ $item->id }}">
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="unit[]" class="form-control" placeholder="pcs / units / sets" value="{{ $item->pivot->unit }}">
                                </td>
                                <td>
                                    <input type="number" name="qty[]" class="form-control" placeholder="Qty" min="1" value="{{ $item->pivot->qty }}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="text" name="product_name[]" class="form-control product-autocomplete" placeholder="Type product name" required>
                                            <span class="input-group-text">
                                                <i class="ti ti-refresh"></i>
                                                <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </span>
                                        </div>
                                        <input type="hidden" name="product_id[]" class="product_id">
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="unit[]" class="form-control" placeholder="pcs / units / sets">
                                </td>
                                <td>
                                    <input type="number" name="qty[]" class="form-control" placeholder="Qty" min="1">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </table>
                        <button type="button" class="btn btn-success btn-sm mb-4" id="addMore">
                            Add More
                            <i class="ti ti-plus"></i>
                        </button>
                        <div>
                            <button type="submit" class="btn btn-primary">Update Supply</button>
                            <a href="{{ route('supplies.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}"></script>
<script>
    $(function() {
        const autocompleteUrl = "{{ route('supplies.product-autocomplete') }}";
        function bindProductAutocomplete($row) {
            const $input = $row.find('.product-autocomplete');
            const $hiddenId = $row.find('.product_id');
            const $loader = $row.find('.product-loader');
            $input.autocomplete({
                minLength: 0,
                source: function(request, response) {
                    $loader.show();
                    $.getJSON(autocompleteUrl, {
                        term: request.term
                    }, function(data) {
                        $loader.hide();
                        response(data);
                    }).fail(function() {
                        $loader.hide();
                        response([]);
                    });
                },
                select: function(event, ui) {
                    $input.val(ui.item.value);
                    $hiddenId.val(ui.item.id);
                    return false;
                },
                change: function(event, ui) {
                    if (!ui.item) {
                        $hiddenId.val('');
                    }
                }
            });
        }

        $('#productTable tr').each(function() {
            if ($(this).find('.product-autocomplete').length) {
                bindProductAutocomplete($(this));
            }
        });

        $('#addMore').on('click', function() {
            const $lastRow = $('#productTable tr').last();
            const $newRow = $lastRow.clone();
            $newRow.find('input').val('');
            $newRow.find('.product_id').val('');
            $('#productTable').append($newRow);
            bindProductAutocomplete($newRow);
        });

        $('#productTable').on('click', '.remove-row', function() {
            if ($('#productTable tr').length > 2) {
                $(this).closest('tr').remove();
            }
        });
       
        $('#supplyForm').on('submit', function() {
            $(this).find('button[type="submit"]')
                .prop('disabled', true)
                .html('Updating... <i class="spinner-border spinner-border-sm"></i>');
        });
    });
</script>
@endpush