@if($data['reviews']->count() > 0)
    <div class="product-reviewlist-section">
        <div class="row">
            <div class="col-lg-12">
                <div class="review-list-container">
                    @foreach($data['reviews'] as $review)
                        <div class="review-list-item">
                            <div class="review-list-header">
                                <div class="rating-dis-flex">
                                    @if(isset($review->rating_star_value) && $review->rating_star_value > 0)
                                        <div class="review-list-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating_star_value ? 're-star-icon-on' : 're-star-icon-off' }}">
                                                    <i data-feather="star"></i>
                                                </span>
                                            @endfor
                                        </div>
                                    @endif
                                    <span class="rate-di-date">
                                        @if($review->review_post_date)
                                            {{ \Carbon\Carbon::parse($review->review_post_date)->format('m/d/Y') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="review-list-profile">
                                    <div class="review-name">
                                        <h6>
                                            {{ $review->review_name ?? 'Anonymous' }}
                                        </h6>                                        
                                        @if($review->is_verified ?? false)
                                            <span class="badge badge-primary">Verified</span>
                                        @endif
                                    </div>
                                    @if($review->reviewFiles && $review->reviewFiles->count() > 0)
                                        <div class="review-dis-img-section rate-collection" data-view="6-3">
                                            @foreach($review->reviewFiles as $file)
                                                @if($file->file_type == 'image')
                                                    <div class="re-img">
                                                        <a href="{{ asset('images/review/' . $file->review_file) }}" 
                                                            data-fancybox="review-gallery-{{ $review->id }}"
                                                            data-caption="Review Image"
                                                            class="d-block rounded-3 overflow-hidden">
                                                            <img src="{{ asset('images/review/' . $file->review_file) }}" 
                                                            class="img-fluid rounded-3 object-fit-cover shadow-sm" 
                                                            alt="Review image"
                                                            loading="lazy"
                                                            width="150"
                                                            height="150">
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="re-img">
                                                        <video controls class="img-fluid"   style="max-height: 100px;">
                                                            <source src="{{ asset('images/review/' . $file->review_file) }}" 
                                                            type="video/{{ pathinfo($file->review_file, PATHINFO_EXTENSION) }}">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="review-message">
                                        @if(!empty($review->review_title))
                                            <div class="review_d_title">
                                                <h6>{{ $review->review_title }}</h6>
                                            </div>
                                        @endif
                                        <p>{{ $review->review_message ?? 'No review message provided' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($data['reviews']->hasPages())
                        <div class="mt-4 pagination-wrapper">
                            {{ $data['reviews']->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif