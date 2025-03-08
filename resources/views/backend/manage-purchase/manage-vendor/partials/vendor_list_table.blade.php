@if(isset($data['vendor_list']) && $data['vendor_list']->count() > 0)
    <table id="example-2" class="table align-middle mb-0 table-hover table-centered">
        <thead class="bg-light-subtle">
            <tr>
                <th>No.</th>
                <th style="width: 20%;">Vendor Name</th>
                <th>Location</th>
                <th>GST No.</th>
                <th>Pnone No.</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sr_no = 1;
            @endphp
            @foreach($data['vendor_list'] as $vendor)
                <tr data-id="{{ $vendor->id }}">
                    <td>{{ $sr_no++ }}</td>
                    <td class="editable-field" data-id="{{ $vendor->id }}">
                        <span class="current-value">{{ $vendor->vendor_name }}</span>
                        <input type="text"  name="vendor_name" class="edit-input form-control" value="{{ $vendor->vendor_name }}" data-field="vendor_name" style="display:none;">
                    </td>
                    <td class="editable-field" data-id="{{ $vendor->id }}">
                        <span class="current-value">{{ $vendor->location }}</span>
                        <input type="text" name="location" class="edit-input form-control" value="{{ $vendor->location }}" data-field="vendor_location" style="display:none;">
                    </td>
                    <td class="editable-field" data-id="{{ $vendor->id }}">
                        <span class="current-value">{{ $vendor->gst_no }}</span>
                        <input type="text" class="edit-input form-control" value="{{ $vendor->gst_no }}" data-field="vendor_gst_no" name="gst_no" style="display:none;">
                    </td>
                    <td class="editable-field" data-id="{{ $vendor->id }}">
                        <span class="current-value">{{ $vendor->contact_no }}</span>
                        <input type="text" class="edit-input form-control" value="{{ $vendor->contact_no }}" data-field="vendor_contact_no" name="phone_no" style="display:none;">
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-vendor-btn" data-vendorid="{{$vendor->id}}" data-bs-original-title="Edit Vendor" data-bs-toggle="tooltip">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-success save-vendor-btn" data-vendorid="{{ $vendor->id }}" style="display:none;">Update</button>
                        <button class="btn btn-sm btn-danger cancel-vendor-btn" data-vendorid="{{ $vendor->id }}" style="display:none;">Cancel</button>
                        
                        <button class="btn btn-sm btn-danger delete-vendor-btn" data-vendorid="{{$vendor->id}}" data-bs-original-title="Delete Vendor" data-bs-toggle="tooltip" data-name="{{ $vendor->vendor_name }}">
                        <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No. Vendor found</p>
@endif

<div class="my-pagination" id="pagination-links">
    {{ $data['vendor_list']->links('vendor.pagination.bootstrap-4') }}
</div>
