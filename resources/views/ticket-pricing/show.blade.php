@extends('layouts.app')

@section('title', 'Ticket Pricing Detail')
@section('ticket-pricing-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-tag tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Ticket Pricing Detail</h5>
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
					<td class="text-left" style="width: 45%;">Title</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$ticket - pricing->title}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Description</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$ticket - pricing->description}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Latitude</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$ticket - pricing->latitude}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Longitude</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$ticket - pricing->longitude}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Created At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$ticket - pricing->created_at}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Updated At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$ticket - pricing->updated_at}}</td>
				</tr>
			</tbody>
		</table>
		<div id="map" class="tw-h-96 tw-my-3 border"></div>
	</x-card>
@endsection

@push('scripts')
	<script>
		$(document).ready(function () {
			let latitude = "{{$ticket - pricing->latitude}}";
			let longitude = "{{$ticket - pricing->longitude}}";
			var map = L.map('map').setView([latitude, longitude], 15);

			L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			L.marker([latitude, longitude]).addTo(map)
				.bindPopup("{{$ticket - pricing->title}}")
				.openPopup();
		});
	</script>
@endpush