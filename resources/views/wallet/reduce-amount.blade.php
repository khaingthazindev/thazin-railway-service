@extends('layouts.app')

@section('title', 'Reduce Wallet')
@section('wallet-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Reduce Amount</h5>
		</div>
		<div></div>
	</div>
@endsection

@section('content')
	<x-card>
		<form id="submit-form" method="post" action="{{ route('wallet-reduce-amount.store') }}" class="tw-mt-6 tw-space-y-6">
			@csrf

			<div class="form-group">
				<x-input-label for="wallet_id" value="Wallet" />
				<select name="wallet_id" id="wallet_id" class="Select2-select custom-select">
					@if ($selected_wallet)
						<option value="{{$selected_wallet->id}}">{{$selected_wallet->user->name}}</option>
					@endif
				</select>
			</div>

			<div class="form-group">
				<x-input-label for="amount" value="Amount" />
				<x-text-input id="amount" name="amount" type="number" class="tw-mt-1 tw-block tw-w-full"
					:value="old('amount')" />
			</div>

			<div class="form-group">
				<x-input-label for="description" value="Description" />
				<textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
			</div>

			<div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
				<x-cancel-button href="{{route('wallet.index')}}">Cancel</x-cancel-button>
				<x-confirm-button>Confirm</x-confirm-button>
			</div>
		</form>
	</x-card>
@endsection

@push('scripts')
	{!! JsValidator::formRequest('App\Http\Requests\WalletReduceAmountStoreRequest', '#submit-form') !!}
	<script>
		$(document).ready(function () {
			$('.Select2-select').select2({
				placeholder: '-- Select Wallet --',
				ajax: {
					url: "{{route('select2-ajax.wallet')}}",
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
									'text': item.user.name
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
		});
	</script>
@endpush