@if($WhatsappConversation->isEmpty())
<p>No conversations found.</p>
@else
<table id="example-1" class="table align-middle mb-0 table-hover table-centered">
    <thead class="bg-light-subtle">
        <tr>
            <th>Sr. No.</th>
            <th>Mobile Number</th>
            <th>Name</th>
            <th>Conversation Message</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $sr = 1;
        @endphp
        @foreach($WhatsappConversation as $conversation)
        <tr>
            <td>{{ $sr }}</td>
            <td>{{ $conversation->mobile_number }}</td>
            <td>{{ $conversation->name }}</td>
            <td>{{ $conversation->conversation_message ?? 'No Message' }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm"  data-editwhatappcon-popup="true" data-size="lg" data-title="Edit {{ $conversation->mobile_number }}" data-bs-toggle="tooltip" data-url="{{ route('manage-whatsapp-conversation.edit', $conversation->id) }}"
                    >
                        <i class="ti ti-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('manage-whatsapp-conversation.destroy', $conversation->id) }}" style="margin-left: 10px;">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                            <a href="javascript:void(0);" title="Delete {{ $conversation->name }}" data-name="{{ $conversation->name }}" class="show_confirm btn btn-soft-danger btn-sm" data-title="Delete {{ $conversation->name }}" data-bs-toggle="tooltip" >
                            <i class="ti ti-trash"></i>
                        </a>
                    </form>
                </div>
            </td>
        </tr>
        @php
            $sr++;
        @endphp
        @endforeach
    </tbody>
</table>
@endif