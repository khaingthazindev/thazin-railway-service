<x-edit-button href="{{route('user.edit', $user->id)}}" class="tw-mr-1"><i class="fas fa-edit"></i></x-edit-button>
<x-delete-button href="#" class="delete-button" data-url="{{route('user.destroy', $user->id)}}"><i
		class="fas fa-trash"></i></x-delete-button>