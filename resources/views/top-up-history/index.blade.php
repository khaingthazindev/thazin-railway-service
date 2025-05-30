@extends('layouts.app')

@section('title', 'Top Up History')
@section('top-up-history-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Top Up History</h5>
		</div>
		<div>
		</div>
	</div>
@endsection

@section('content')
	<x-card class="tw-pb-5">
		<table class="table table-bordered Datatable-tb" id="images">
			<thead>
				<tr>
					<th></th>
					<th class="text-center">Trx ID</th>
					<th class="text-center">User</th>
					<th class="text-center">Amount</th>
					<th class="text-center">Image</th>
					<th class="text-center">Status</th>
					<th class="text-center">Created at</th>
					<th class="text-center">Updated at</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
		</table>
	</x-card>
@endsection

@push('scripts')
	<script>
		$(document).ready(function () {
			let images = new Viewer(document.getElementById('images'));

			let datatableTb = new DataTable('.Datatable-tb', {
				processing: true,
				serverSide: true,

				ajax: {
					url: "{{route('top-up-history-datatable')}}",
					data: function (d) {
					},
				},
				columns: [
					{ data: 'responsive-icon', class: 'text-center' },
					{ data: 'trx_id', class: 'text-center' },
					{ data: 'user_name', class: 'text-center' },
					{ data: 'amount', class: 'text-center' },
					{ data: 'image', class: 'text-center' },
					{ data: 'status', class: 'text-center' },
					{ data: 'created_at', class: 'text-center' },
					{ data: 'updated_at', class: 'text-center' },
					{ data: 'action', class: 'text-center' },
				],
				order: [
					[7, 'desc'],
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
				},
				drawCallback: function () { //after datatable draw
					images.destroy(); // not to duplicate viewer instance on same DOM
					images = new Viewer(document.getElementById('images'));
				}
			});

			$(document).on('click', '.reject-button', function (e) {
				e.preventDefault();
				let rejectUrl = $(this).data('url');
				confirmDialog.fire({
					title: 'Are you sure, you want to reject?',
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: rejectUrl,
							method: 'POST',
							success: function (response) {
								datatableTb.ajax.reload();

								toastr.success(response.message);
							}
						});
					}
				});
			});

			$(document).on('click', '.approve-button', function (e) {
				e.preventDefault();
				let approveUrl = $(this).data('url');
				confirmDialog.fire({
					title: 'Are you sure, you want to approve?',
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: approveUrl,
							method: 'POST',
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