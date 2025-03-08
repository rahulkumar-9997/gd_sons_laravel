@if (isset($data['groups_category_list']) && $data['groups_category_list']->count() > 0)
<div class="table-responsive1">
    <table id="example-1" class="table align-middle mb-0 table-hover table-centered">
        <thead class="bg-light-subtle">
            <tr>
                <th>Sr. No.</th>
                <th>Group Category Name</th>
                <th>Group Category Percentage (%)</th>
                <th>Status</th>
                <th>Groups</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $sr_no = 1;
            @endphp
            @foreach($data['groups_category_list'] as $groups_category_list_row)
            <tr>
            <td>{{ $sr_no }}</td>
                <td>
                    {{ $groups_category_list_row->name }}

                </td>
                <td>
                    {{ $groups_category_list_row->group_category_percentage }}

                </td>
                <td>
                    @if($groups_category_list_row->status == '1')
                    <span class="badge border border-success text-success  px-2 py-1 fs-13">Aactive</span>
                    @else
                    <span class="badge border border-danger text-danger  px-2 py-1 fs-13">Inactive</span>
                    @endif
                </td>
                <td>
                @if ($groups_category_list_row->groups->isNotEmpty()) 
                    @foreach ($groups_category_list_row->groups as $group) 
                        <a href="#" class="badge border border-primary text-primary px-1 py-1 fs-10">
                            {{$group->name}} 
                        </a>
                    @endforeach
                @else
                    No groups available for this group category.
                @endif
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="javascript:void(0);"
                        data-editgroupcategory-popup="true" data-groupcateid="{{$groups_category_list_row->id}}" data-size="lg" data-title="Edit {{ $groups_category_list_row->name }}"
                        data-url="{{ route('edit-group-category', $groups_category_list_row->id) }}"
                        data-bs-toggle="tooltip" data-bs-original-title="Edit {{ $groups_category_list_row->name }}"
                        class="btn btn-soft-success btn-sm">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('group-category.delete', $groups_category_list_row->id) }}" style="margin-left: 10px;">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                                <a href="javascript:void(0);" title="Delete {{ $groups_category_list_row->name }}" data-name="{{ $groups_category_list_row->name }}" class="show_confirm_group_category btn btn-soft-danger btn-sm" data-title="Delete {{ $groups_category_list_row->name }}" data-bs-toggle="tooltip" >
                                <i class="ti ti-trash"></i>
                            </a>
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
@endif