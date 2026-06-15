<div class="table-responsive1">
    <table class="table align-middle mb-0 table-hover table-centered">
        <thead class="bg-light-subtle">
            <tr>
                <th>Sr. No.</th>
                <th>
                    Name
                </th>
                <th>Category</th>
                <th style="width: 30%;">Blog Details</th>
                <th>Blog Img</th>
                <th>Paragraphs</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $sr_no = 1;
            @endphp
            @foreach($blogs as $blogs_row)
            <tr>
                <td>{{ $sr_no }}</td>
                <td>
                    {{ $blogs_row->title }}
                    <span class="badge bg-pink ms-1" title="Visitor Count {{ $blogs_row->view }}">
                        <i class="ti ti-eye"></i> {{ $blogs_row->view }}
                    </span>
                </td>
                <td>{{ $blogs_row->category->title }}</td>
                <td>
                    <div style="max-width: 250px;">
                        {!! \Illuminate\Support\Str::limit(strip_tags($blogs_row->bog_description), 60) !!}
                    </div>
                </td>
                <td>
                    <img src="{{ asset($blogs_row->blog_image) }}" class="img-thumbnail" style="width: 70px; height: 70px;" alt="{{ $blogs_row->title }}">
                </td>
                <td>
                    <span class="badge bg-primary ms-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $blogs_row->title }}">
                        {{ $blogs_row->paragraphs->count() }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('manage-blog.edit', $blogs_row->id) }}" class="btn btn-soft-primary btn-sm"
                            data-bs-toggle="tooltip" data-bs-original-title="{{ $blogs_row->title }}">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('manage-blog.destroy', $blogs_row->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" data-name="{{ $blogs_row->title }}" class="btn btn-soft-danger btn-sm show_confirm"><i class="ti ti-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @php
            $sr_no++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
<div class="my-pagination mt-2 mb-2">
    {{ $blogs->links('vendor.pagination.bootstrap-4') }}
</div>