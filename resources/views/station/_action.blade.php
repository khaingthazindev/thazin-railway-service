<x-detail-button href="{{route('station.show', $station->id)}}" class="tw-mr-1"><i
		class="fas fa-info-circle"></i></x-detail-button>
<x-edit-button href="{{route('station.edit', $station->id)}}" class="tw-mr-1"><i
		class="fas fa-edit"></i></x-edit-button>
<x-delete-button href="#" class="delete-button" data-url="{{route('station.destroy', $station->id)}}"><i
		class="fas fa-trash"></i></x-delete-button>