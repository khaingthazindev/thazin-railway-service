@extends('layouts.app')

@section('title', 'Edit Admin User')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-user tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Edit Admin User</h5>
		</div>
		<div></div>
	</div>
@endsection

@section('content')
	<x-card>
		<form id="submit-form" method="post" action="{{ route('admin-user.update', $admin_user->id) }}"
			class="tw-mt-6 tw-space-y-6">
			@csrf
			@method('put')

			<div class="form-group">
				<x-input-label for="name" value="Name" />
				<x-text-input id="name" name="name" type="text" class="tw-mt-1 tw-block tw-w-full"
					value="{{ old('name', default: $admin_user->name) }}" />
			</div>

			<div class="form-group">
				<x-input-label for="email" value="Email" />
				<x-text-input id="email" name="email" type="email" class="tw-mt-1 tw-block tw-w-full"
					value="{{ old('email', default: $admin_user->email) }}" />
			</div>

			<div class="form-group">
				<x-input-label for="password" value="Password" />
				<x-text-input id="password" name="password" type="password" class="tw-mt-1 tw-block tw-w-full" />
			</div>

			<div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
				<x-cancel-button href="{{route('dashboard')}}">Cancel</x-cancel-button>
				<x-confirm-button>Confirm</x-confirm-button>
			</div>
		</form>
	</x-card>
@endsection

@push('scripts')
	{!! JsValidator::formRequest('App\Http\Requests\AdminUserUpdateRequest', '#submit-form') !!}
@endpush