<table class="table align-middle mb-0 table-hover table-centered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Desktop</th>
            <th>Mobile</th>
            <th>Status</th>
            <th>Schedule</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($popups as $popup)
        <tr>
            <td>{{ $popup->title ?? '-' }}</td>
            <td><img src="{{ asset('storage/images/offer/'.$popup->desktop_image) }}" width="70"></td>
            <td><img src="{{ asset('storage/images/offer/'.$popup->mobile_image) }}" width="50"></td>
           <td>
                <div class="form-check form-switch">
                    <input type="checkbox"
                        class="form-check-input status-toggle"
                        role="switch"
                        id="statusToggle{{ $popup->id }}"
                        data-url="{{ route('offer-popups.toggle-status', $popup) }}"
                        {{ $popup->is_active ? 'checked' : '' }}>
                    <label class="form-check-label small" for="statusToggle{{ $popup->id }}">
                        <span class="status-text">{{ $popup->is_active ? 'Active' : 'Inactive' }}</span>
                    </label>
                </div>
            </td>
            <td>
                @if($popup->starts_at || $popup->ends_at)
                {{ optional($popup->starts_at)->format('d M Y') }} – {{ optional($popup->ends_at)->format('d M Y') }}
                @else
                Always
                @endif
            </td>
            <td>
                <div class="d-flex gap-2">
                    <a href="{{ route('offer-popups.edit', $popup) }}"
                        class="btn btn-soft-primary btn-sm"
                        data-title="Edit Popup Offer">
                        <i class="ti ti-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('offer-popups.destroy', $popup) }}">
                        @csrf
                        @method('DELETE')
                        <a href="javascript:void(0);"
                            class="btn btn-soft-danger btn-sm show_confirm_offer"
                            data-name="data-name="{{ $popup->title ?? '-' }}"">
                            <i class="ti ti-trash"></i>
                        </a>
                    </form>
                </div>               
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No offer popups yet.</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $popups->links() }}  