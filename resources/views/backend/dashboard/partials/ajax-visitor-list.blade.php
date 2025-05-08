@if($data['visitor_list']->isEmpty())
        <div class="alert alert-warning">No visitors found.</div>
    @else
        <table  class="table align-middle mb-0 table-hover table-centered">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>IP Address</th>
                    <!-- <th>Browser</th> -->
                    <th style="width: 10%;">Page Url</th>
                    <th style="width: 10%;">Page Title</th>
                    <th>Customer Name</th>
                    <th>Visited At</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $srNo = 1;
                @endphp
                @foreach ($data['visitor_list'] as $visitor)
                <tr>
                    <td>{{ $srNo }}</td>
                    <td>{{ $visitor->ip_address }}</td>
                    <!-- <td style="width: 15%;">
                        <div class="overflow-auto" style="max-width: 100px; white-space: nowrap;">
                            {{ $visitor->browser }}
                        </div>
                    </td> -->
                    <td style="width: 30%;">
                        <div class="overflow-auto" style="max-width: 300px; white-space: nowrap;">
                            {{ $visitor->page_name }}
                        </div>
                    </td>
                    <td style="width: 10%;">
                        {{ $visitor->page_title }}
                    </td>
                    <td style="width: 20%;">
                        {{ $visitor->customer_name }}
                    </td>
                    <td>{{ $visitor->visited_at }}</td>
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