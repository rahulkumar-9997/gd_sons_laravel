@if (isset($primaryCategory) && $primaryCategory->count() > 0)
<div class="table-responsive1">
    <table class="table align-middle mb-0 table-hover table-centered">
        <thead class="bg-light-subtle">
            <tr>
                <th>Sr. No.</th>
                <th>Name</th>
                <th>Status</th>
                <th>Url</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $sr_no = 1; @endphp
            @foreach($primaryCategory as $primaryCategoryRow)
            @php
            $firstProduct = $primaryCategoryRow->products->first();
            $totalProducts = $primaryCategoryRow->products->count();
            @endphp
            <tr>
                <td>{{ $sr_no }}</td>
                <td>
                    {{ $primaryCategoryRow->title }}
                    @if($firstProduct)
                    <br>
                    <span class="badge bg-primary">
                        {{ $firstProduct->title }}
                    </span>
                    @if($totalProducts > 1)
                    <span class="badge bg-secondary"
                        data-bs-toggle="tooltip"
                        title="{{ $primaryCategoryRow->products->pluck('title')->implode(', ') }}">
                        +{{ $totalProducts - 1 }}
                    </span>
                    @endif
                    @endif
                </td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input primaryCategoryStatus"
                            data-pid="{{ $primaryCategoryRow->id }}"
                            data-url="{{ route('manage-primary-category.status', $primaryCategoryRow->id) }}"
                            type="checkbox"
                            @if($primaryCategoryRow->status) checked @endif>
                    </div>
                </td>
                <td>
                    <div style="max-width: 250px; overflow:auto; white-space:nowrap;">
                        {{ $primaryCategoryRow->link }}
                    </div>
                </td>
                <td>
                    <div style="max-width: 250px;">
                        {!! \Illuminate\Support\Str::limit(strip_tags($primaryCategoryRow->primary_category_description), 60) !!}
                    </div>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('manage-primary-category.edit', $primaryCategoryRow->id) }}"
                            class="btn btn-soft-primary btn-sm">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('manage-primary-category.destroy', $primaryCategoryRow->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                data-name="{{ $primaryCategoryRow->title }}"
                                class="btn btn-soft-danger btn-sm show_confirm">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @php $sr_no++; @endphp
            @endforeach
        </tbody>
    </table>
</div>
<div class="my-pagination mt-3" id="pagination-links">
    {{ $primaryCategory->links('vendor.pagination.bootstrap-4') }}
</div>
@endif