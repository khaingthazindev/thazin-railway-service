@extends('layouts.app')

@section('title', 'Wallet')
@section('wallet-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Wallet</h5>
		</div>
		<div>
			<x-create-button href="{{route('wallet-add-amount')}}">
				<i class="fas fa-plus-circle tw-mr-1"></i>
				Add Amount
			</x-create-button>
			<x-create-button href="{{route('wallet-reduce-amount')}}">
				<i class="fas fa-minus-circle tw-mr-1"></i>
				Reduce Amount
			</x-create-button>
		</div>
	</div>
@endsection

@section('content')
	<x-card class="tw-pb-5">
		<table class="table table-bordered Datatable-tb">
			<thead>
				<tr>
					<th></th>
					<th class="text-center">User</th>
					<th class="text-center">Amount</th>
					<th class="text-center">Created at</th>
					<th class="text-center">Updated at</th>
				</tr>
			</thead>
		</table>
	</x-card>
@endsection

@push('scripts')
	<script>
		$(document).ready(function () {
			let datatableTb = new DataTable('.Datatable-tb', {
				processing: true,
				serverSide: true,

				ajax: {
					url: "{{route('wallet-datatable')}}",
					data: function (d) {
					},
				},
				columns: [
					{ data: 'responsive-icon', class: 'text-center' },
					{ data: 'user_name', class: 'text-center' },
					{ data: 'amount', class: 'text-center' },
					{ data: 'created_at', class: 'text-center' },
					{ data: 'updated_at', class: 'text-center' },
				],
				order: [
					[4, 'desc'],
				],
				columnDefs: [
					{
						targets: 'no-sort',
						orderable: false
					},
					{
						targets: 'no-search',
						searchable: false
					},
					{
						targets: 0,
						searchable: false,
						orderable: false,
						className: 'dtr-control'
					},
				],
				responsive: {
					details: {
						target: 0,
						type: 'column',
					}
				}
			});
		});
	</script>
@endpush