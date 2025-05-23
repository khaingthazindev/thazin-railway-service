@extends('layouts.app')

@section('title', 'Wallet Transaction Detail')
@section('wallet-transaction-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Wallet Transaction Detail</h5>
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
					<td class="text-right" style="width: 45%;">{{$wallet_transaction->trx_id}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">From</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$wallet_transaction->from['text']}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">To</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$wallet_transaction->to['text']}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Type</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%"><span
							style="color: {{$wallet_transaction->type['color']}}">{{$wallet_transaction->type['text']}}</span>
					</td>
				</tr>
				<tr>
					<td class=" text-left" style="width: 45%;">Amount</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">
						<span
							style="color: {{$wallet_transaction->method['color']}}">{{number_format($wallet_transaction->amount)}}</span>
						MMK
					</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Description</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$wallet_transaction->description}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Created At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$wallet_transaction->created_at}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Updated At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$wallet_transaction->updated_at}}</td>
				</tr>
			</tbody>
		</table>
	</x-card>
@endsection

@push('scripts')
	<script>

	</script>
@endpush