@extends('layouts.app')

@section('title', 'Create Route')
@section('route-page-active', 'active')

@section('styles')
	<style>
		.calendar-table {
			display: none;
		}

		.daterangepicker .drp-calendar.left {
			padding: 8px;
		}
	</style>
@endsection

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-route tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Create Route</h5>
		</div>
		<div></div>
	</div>
@endsection

@section('content')
	<x-card>
		<form id="submit-form" method="post" action="{{ route('route.store') }}" class="repeater tw-mt-6 tw-space-y-6">
			@csrf

			<div class="form-group">
				<x-input-label for="title" value="Title" />
				<x-text-input id="title" name="title" type="text" class="tw-mt-1 tw-block tw-w-full" :value="old('title')" />
			</div>

			<div class="form-group">
				<x-input-label for="description" value="Description" />
				<textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
			</div>

			<div class="form-group">
				<x-input-label for="" value="Direction" />
				<select name="direction" class="custom-select">
					<option value="clockwise" @if (old('direction') === 'clockwise') selected @endif>Clockwise</option>
					<option value="anti_clockwise" @if (old('direction') === 'anti_clockwise') selected @endif>Anticlockwise
					</option>
				</select>
			</div>

			<div>
				<x-input-label for="" value="Schedule" />
				<div data-repeater-list="schedule">

					@if ($schedules)
						@foreach ($schedules as $schedule)
							<div data-repeater-item class="tw-relative tw-mb-3 tw-p-3 tw-border tw-border-gray-300 tw-rounded-lg">
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<x-input-label for="" value="Station" />
											<select name="station_id" class="Select2-select custom-select station_id">
												<option value="{{$schedule['station_id']}}">{{$schedule['title']}}</option>
											</select>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<x-input-label for="time" value="Time" />
											<x-text-input id="time" name="time" type="text" class="timepicker tw-mt-1 tw-block tw-w-full"
												value="{{$schedule['time']}}" />
										</div>
									</div>
								</div>
								<button data-repeater-delete type="button"
									class="tw-absolute tw-top-0 tw-right-0 tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-red-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-red-700 focus:tw-bg-red-700 active:tw-bg-red-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150"><i
										class="fas fa-times-circle"></i></button>
							</div>

						@endforeach
					@else
						<div data-repeater-item class="tw-relative tw-mb-3 tw-p-3 tw-border tw-border-gray-300 tw-rounded-lg">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<x-input-label for="" value="Station" />
										<select name="station_id" class="Select2-select custom-select station_id">

										</select>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<x-input-label for="time" value="Time" />
										<x-text-input id="time" name="time" type="text" class="timepicker tw-mt-1 tw-block tw-w-full" />
									</div>
								</div>
							</div>
							<button data-repeater-delete type="button"
								class="tw-absolute tw-top-0 tw-right-0 tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-red-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-red-700 focus:tw-bg-red-700 active:tw-bg-red-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150"><i
									class="fas fa-times-circle"></i></button>
						</div>
					@endif
				</div>
				<button data-repeater-create type="button" value="Add"
					class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-gray-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-gray-700 focus:tw-bg-gray-700 active:tw-bg-gray-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150"><i
						class="fas fa-plus-circle tw-mr-1"></i> Add Schedule</button>
			</div>

			<div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
				<x-cancel-button href="{{route('route.index')}}">Cancel</x-cancel-button>
				<x-confirm-button>Confirm</x-confirm-button>
			</div>
		</form>
	</x-card>
@endsection

@push('scripts')
	{!! JsValidator::formRequest('App\Http\Requests\RouteStoreRequest', '#submit-form') !!}

	<script>
		$(document).ready(function () {
			$('.repeater').repeater({
				show: function () {
					$(this).slideDown();
					initStationSelect2();
					initTimePicker();
				},
				hide: function (deleteElement) {
					if (confirm('Are you sure you want to delete this element?')) {
						$(this).slideUp(deleteElement);
					}
				},
				ready: function () {
					initStationSelect2();
					initTimePicker();
				},
				isFirstItemUndeletable: true
			});

			function initStationSelect2() {
				$('.Select2-select').select2({
					placeholder: '-- Select Station --',
					ajax: {
						url: "{{route('select2-ajax.station')}}",
						data: function (params) {
							return {
								search: params.term,
								page: params.page || 1
							}
						},
						processResults: function (res) {
							return {
								results: res.data.map(function (item) {
									return {
										'id': item.id,
										'text': item.title
									}
								}),
								pagination: {
									more: res.next_page_url ? true : false
								}
							};
						},
						cache: true
					}
				});
			}

			function initTimePicker() {
				$('.timepicker').daterangepicker({
					"singleDatePicker": true,
					"timePicker": true,
					"timePicker24Hour": true,
					"timePickerSeconds": true,
					"autoApply": true,
					"locale": {
						"format": "HH:mm:ss",
					}
				});
			}
		});
	</script>
@endpush