@extends('layouts.app')

@section('title', 'Edit Station')
@section('station-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-subway tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Edit Station</h5>
		</div>
		<div></div>
	</div>
@endsection

@section('content')
	<x-card>
		<form id="submit-form" method="post" action="{{ route('station.update', $station->id) }}"
			class="tw-mt-6 tw-space-y-6">
			@csrf
			@method('PUT')

			<div class="form-group">
				<x-input-label for="title" value="Title" />
				<x-text-input id="title" name="title" type="text" class="tw-mt-1 tw-block tw-w-full" :value="old('title', $station->title)" />
			</div>

			<div class="form-group">
				<x-input-label for="description" value="Description" />
				<textarea name="description" id="description"
					class="form-control">{{old('description', $station->description)}}</textarea>
			</div>

			<div class="form-group">
				<x-input-label for="location" value="Location" />
				<x-text-input id="location" name="location" type="text" class="location tw-mt-1 tw-block tw-w-full"
					:value="old('location', $station->latitude . ',' . $station->longitude)" />
				<div class="map-container tw-my-3 border"></div>
			</div>

			<div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
				<x-cancel-button href="{{route('station.index')}}">Cancel</x-cancel-button>
				<x-confirm-button>Confirm</x-confirm-button>
			</div>
		</form>
	</x-card>
@endsection

@push('scripts')
	{!! JsValidator::formRequest('App\Http\Requests\StationUpdateRequest', '#submit-form') !!}

	<script>
		$(document).ready(function () {
			$('.location').leafletLocationPicker({
				alwaysOpen: true,
				mapContainer: '.map-container',
				height: 400,
				// layer: 'mapTailer',
				map: {
					center: [16.781838250331322, 96.16154535383613],
					zoom: 15
				}
			});
		});
	</script>
@endpush