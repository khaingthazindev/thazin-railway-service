@extends('layouts.app')

@section('title', 'Edit Ticket Pricing')
@section('ticket-pricing-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-tag tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Edit Ticket Pricing</h5>
		</div>
		<div></div>
	</div>
@endsection

@section('content')
	<x-card>
		<form id="submit-form" method="post" action="{{ route('ticket-pricing.update', $ticket_pricing->id) }}"
			class="tw-mt-6 tw-space-y-6">
			@csrf
			@method('PUT')

			<div class="form-group">
				<x-input-label for="" value="Type" />
				<select name="type" class="custom-select">
					<option value="one_time_ticket" @if (old('type', $ticket_pricing->type) === 'one_time_ticket') selected
					@endif>One Time Ticket
					</option>
					<option value="one_month_ticket" @if (old('type', $ticket_pricing->type) === 'one_month_ticket') selected
					@endif>One Month Ticket
					</option>
				</select>
			</div>

			<div class="form-group">
				<x-input-label for="price" value="Price" />
				<x-text-input id="price" name="price" type="number" class="tw-mt-1 tw-block tw-w-full" :value="old('price', $ticket_pricing->price)" />
			</div>

			<div class="form-group">
				<x-input-label for="offer_quantity" value="Offer Quantity" />
				<x-text-input id="offer_quantity" name="offer_quantity" type="number" class="tw-mt-1 tw-block tw-w-full"
					:value="old('offer_quantity', $ticket_pricing->offer_quantity)" />
			</div>

			<div class="form-group">
				<x-input-label for="period" value="Period" />
				<x-text-input id="period" name="period" type="text" class="timepicker tw-mt-1 tw-block tw-w-full"
					value="{{old('period', $ticket_pricing->started_at . ' - ' . $ticket_pricing->ended_at)}}" />
			</div>

			<div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
				<x-cancel-button href="{{route('ticket-pricing.index')}}">Cancel</x-cancel-button>
				<x-confirm-button>Confirm</x-confirm-button>
			</div>
		</form>
	</x-card>
@endsection

@push('scripts')
	{!! JsValidator::formRequest('App\Http\Requests\TicketPricingStoreRequest', '#submit-form') !!}

	<script>
		$(document).ready(function () {
			$('.timepicker').daterangepicker({
				"timePicker": true,
				"timePicker24Hour": true,
				"timePickerSeconds": true,
				"autoApply": true,
				"drops": "up",
				"locale": {
					"format": "YYYY-MM-DD HH:mm:ss",
				}
			});
		});
	</script>
@endpush