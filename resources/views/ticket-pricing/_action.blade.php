<x-edit-button href="{{route('ticket-pricing.edit', $ticket_pricing->id)}}" class="tw-mr-1"><i
		class="fas fa-edit"></i></x-edit-button>
<x-delete-button href="#" class="delete-button" data-url="{{route('ticket-pricing.destroy', $ticket_pricing->id)}}"><i
		class="fas fa-trash"></i></x-delete-button>