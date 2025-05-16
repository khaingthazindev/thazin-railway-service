@extends('layouts.app')

@section('title', 'Top Up History Detail')
@section('wallet-transaction-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Top Up History Detail</h5>
		</div>
		<div>
		</div>
	</div>
@endsection

@section('content')
	<x-card class="tw-pb-5">
		<table class="tw-w-full">
			<tbody>
				<tr>
					<td class="text-left" style="width: 45%;">Trx ID</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->trx_id}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">From</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->from['text']}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">To</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->to['text']}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Created At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->created_at}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Description</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->description}}</td>
				</tr>
			</tbody>
		</table>
	</x-card>
@endsection

@push('scripts')
	<script>

	</script>
@endpush