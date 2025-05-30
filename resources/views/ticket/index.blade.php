@extends('layouts.app')

@section('title', 'Ticket')
@section('ticket-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-ticket-alt tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Ticket</h5>
		</div>
		<div>
			<x-create-button href="{{route('ticket.create')}}">
				<i class="fas fa-plus-circle tw-mr-1"></i>
				Create
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
					<th class="text-center">Ticket Number</th>
					<th class="text-center">User</th>
					<th class="text-center">Type</th>
					<th class="text-center">Direction</th>
					<th class="text-center">Price (MMK)</th>
					<th class="text-center">Valid at</th>
					<th class="text-center">Expire at</th>
					<th class="text-center">Created at</th>
					<th class="text-center">Updated at</th>
					{{-- <th class="text-center no-sort no-search">Action</th> --}}
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
					url: "{{route('ticket-datatable')}}",
					data: function (d) {
					},
				},
				columns: [
					{ data: 'responsive-icon', class: 'text-center' },
					{ data: 'ticket_number', class: 'text-center' },
					{ data: 'user_name', class: 'text-center' },
					{ data: 'type', class: 'text-center' },
					{ data: 'direction', class: 'text-center' },
					{ data: 'price', class: 'text-center' },
					{ data: 'valid_at', class: 'text-center' },
					{ data: 'expire_at', class: 'text-center' },
					{ data: 'created_at', class: 'text-center' },
					{ data: 'updated_at', class: 'text-center' },
					// { data: 'action', class: 'text-center' },
				],
				order: [
					[6, 'desc'],
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

			$(document).on('click', '.delete-button', function (e) {
				e.preventDefault();
				let deleteUrl = $(this).data('url');
				confirmDialog.fire({
					title: 'Are you sure, you want to delete?'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: deleteUrl,
							method: 'DELETE',
							success: function (response) {
								datatableTb.ajax.reload();

								toastr.success(response.message);
							}
						});
					}
				});
			});
		});
	</script>
@endpush