@if($data['image_storage']->isNotEmpty())
<form action="{{ route('mapped-image-to-product.submit')}}" method="post" id="imageMappedToProduct" accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf
    <div class="fixed-submit-container">
        <div class="row">
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text" id="product_name" name="product_name" class="form-control storage-product-autocomplete ui-autocomplete-input" autocomplete="off" placeholder="Select a Product">

                        <span class="input-group-text">
                            <i class="ti ti-refresh"></i>
                            <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </span>
                    </div>
                    <input type="hidden" name="product_id" class="product_id">
                </div>
            </div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-primary w-100">Map Selected Images to Product</button>
            </div>
        </div>
    </div>
    <div class="images-container mt-0">
        <div class="row">
            @foreach($data['image_storage'] as $image_storage)
            <div class="col-md-3 col-xl-3">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selected_images[]"
                            value="{{ $image_storage->id }}" id="image_{{ $image_storage->id }}">
                        <label class="form-check-label" for="image_{{ $image_storage->id }}">
                            Select
                        </label>
                    </div>
                    <div class="product-element-top">
                        <img src="{{ asset('images/storage/' . $image_storage->image_storage_path) }}" alt="img"
                            class="img-fluid img-thumbnail thumbnail">
                    </div>
                    <div class="rounded-bottom">
                        <div class="mt-1">
                            <div class="d-flex gap-2 mb-2" id="storage_img_area_{{ $image_storage->id }}">
                                <div>
                                    <input type="text" placeholder="Enter image comments..." id="storage_comment_{{ $image_storage->id }}" name="storage_comment" class="form-control" value="{{ $image_storage->comments}}">
                                </div>
                                <div>
                                    <button type="submit"
                                    data-storageid="{{ $image_storage->id}}"
                                    data-route="{{ route('manage-storage.comment.submit', $image_storage->id) }}"
                                    class="btn btn-primary w-100 comment-submit-btn">Submit</button>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="javascript:void(0);" 
                                    data-url="{{ route('manage-storage.delete', ['id' => $image_storage->id]) }}"
                                    class="btn btn-outline-dark border border-secondary-subtle d-flex align-items-center justify-content-center gap-1 w-100 show_confirm"
                                    data-id="{{ $image_storage->id }}">
                                    Delete Image
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</form>
@endif