<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th style="width: 20%;">Product Name</th>
            <th>Rating</th>
            <th>Reviewer Name</th>
            <th>Review Date</th>
            <th>Status</th>
            <th>Total Reviews (Product)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $index => $review)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>
                {{ $review->product->title }}
            </td>
            <td>
                @for($i = 1; $i <= 5; $i++)
                    @if($i <=$review->rating_star_value)
                    <i class="ti ti-star-filled text-warning"></i>
                    @else
                    <i class="ti ti-star text-warning"></i>
                    @endif
                @endfor
                <br>
                ({{ $review->rating_star_value }})
            </td>
            <td>{{ $review->review_name }}</td>
            <td>
                {{ \Carbon\Carbon::parse($review->review_post_date)->format('d M Y h:i A') }}
            </td>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input productReviewStatus" data-pid="{{ $review->id }}" data-url="{{ route('manage-rating.status', $review->id) }}" type="checkbox" role="switch"
                        @if($review->status == 1) checked @endif>
                </div>
                @if($review->status == 1)
                <span class="badge bg-success">Approved</span>
                @else
                <span class="badge bg-warning">Pending</span>
                @endif
            </td>
            <td>
                @if($review->product)
                <span class="badge bg-primary ms-1" data-bs-toggle="tooltip"
                    data-bs-original-title="Total review on this products {{ $review->product->title }}">
                    {{ $review->product->reviews_count }}
                </span>
                @else
                <span class="badge bg-primary ms-1" data-bs-toggle="tooltip"
                    data-bs-original-title="This review is not published, so the count shows 0">
                    {{ $review->product->reviews_count }}
                </span>
                @endif
            </td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('manage-rating.show', $review->id) }}" class="btn btn-soft-primary btn-sm" title="View">
                        <i class="ti ti-eye"></i>
                    </a>
                    <a href="{{ route('manage-rating.edit', $review->id) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                        <i class="ti ti-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('manage-rating.destroy', $review->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-soft-danger btn-sm show_confirm_product_review" data-name="{{ $review->review_name }}" title="Delete">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($reviews->isEmpty())
<div class="alert alert-info">No reviews found.</div>
@endif
<div class="my-pagination" id="pagination-link-product-review">
    {{ $reviews->links('vendor.pagination.bootstrap-4') }}
</div>
