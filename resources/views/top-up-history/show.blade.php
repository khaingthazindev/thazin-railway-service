@extends('layouts.app')

@section('title', 'Top Up History Detail')
@section('top-up-history-page-active', 'active')

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
					<td class="text-left" style="width: 45%;">User</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->user?->name}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Amount</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{number_format($top_up_history->amount)}} MMK</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Description</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->description ?? '-'}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Status</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;"><span
							style="color: {{$top_up_history->acsrStatus['color']}}">{{$top_up_history->acsrStatus['text']}}</span>
					</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Approved At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->approved_at ?? '-'}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Rejected At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->rejected_at ?? '-'}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Created At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->created_at}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Updated At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$top_up_history->updated_at}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Image</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">
						<div class="tw-flex tw-justify-end tw-align-items-center">
							<img src="{{$top_up_history->imageUrl}}" alt="" class="tw-w-20 tw-rounded tw-cursor-pointer"
								id="image">
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</x-card>
@endsection

@push('scripts')
	<script>
		$(document).ready(function () {
			let images = new Viewer(document.getElementById('image'));
		});
	</script>
@endpush