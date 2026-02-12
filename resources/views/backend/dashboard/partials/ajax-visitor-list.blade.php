@if($data['visitor_list']->isEmpty())
    <div class="alert alert-warning">No visitors found.</div>
@else
    <button type="button" class="btn btn-sm btn-danger mb-2" id="deleteSelectedVisitors">
        Delete Selected
    </button>
    <table class="table align-middle mb-0 table-hover table-centered">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAllVisitors">
                </th>
                <th>#</th>
                <th>IP Address</th>
                <th>Device Name</th>
                <!--th>Page Url</th-->
                <th>Page Title</th>
                <th>Total Visits</th>
                <th>Customer Name</th>
                <th>Visited At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $srNo = 1;
            @endphp
            @foreach ($data['visitor_list'] as $visitor)
            @php
                $pageKey = $visitor->page_name;
                $visitCount = $data['page_counts'][$pageKey]->visitor_count ?? 0;
				if($visitor->page_title == 'Best Kitchen Retail Store in Varanasi now goes Online')
					$visitor->page_title = 'Home Page';
				else
					$visitor->page_title = $visitor->page_title;
            @endphp
            <tr>
                 <td>
                    <input type="checkbox"
                        class="visitor-checkbox"
                        value="{{ $visitor->id }}">
                </td>
                <td>{{ $srNo }}</td>
                <td>{{ $visitor->ip_address }}</td>
                <td>{{ $visitor->device_category }}</td>
                <!--td style="width: 15%;">
                    <div class="overflow-auto" style="max-width: 250px; white-space: nowrap;">
                        {{ $visitor->page_name }}
                    </div>
                </td-->
                <td style="width: 15%;">
                    <div class="overflow-auto" style="max-width: 350px;">
                        <a target="_blank" href="{{ $visitor->page_name }}">{{ $visitor->page_title }}</a>
                    </div>
                </td>
                <td>
                    <span class="badge bg-primary ms-1" data-bs-toggle="tooltip" data-bs-original-title="Total visit this page url">
                        {{ $visitCount }}
                    </span>
                </td>
                <td style="width: 20%;">
                    {{ $visitor->customer_name }}
                </td>
                <td style="width: 15%;">
                    {{ \Carbon\Carbon::parse($visitor->visited_at)->format('d M Y') }}<br>
                    {{ \Carbon\Carbon::parse($visitor->visited_at)->format('h:i:s A') }}
                </td>
            </tr>
            @php
                $srNo++;
            @endphp
            @endforeach
        </tbody>
    </table>
    
    <div class="my-pagination" id="pagination-links-visitor">
        {{ $data['visitor_list']->links('vendor.pagination.bootstrap-4') }}
    </div>
@endif