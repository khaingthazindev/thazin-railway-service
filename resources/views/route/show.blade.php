@extends('layouts.app')

@section('title', 'Route Detail')
@section('route-page-active', 'active')

@section('header')
	<div class="tw-flex tw-justify-between tw-items-center">
		<div class="tw-flex tw-justify-between tw-items-center">
			<i class="fas fa-subway tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
			<h5>Route Detail</h5>
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
					<td class="text-right" style="width: 45%;">{{$route->title}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Description</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$route->description}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Direction</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;"><span
							style="color: {{$route->acsr_direction['color']}}">{{$route->acsr_direction["text"]}}</span></td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Created At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$route->created_at}}</td>
				</tr>
				<tr>
					<td class="text-left" style="width: 45%;">Updated At</td>
					<td class="text-center" style="width: 10%;">...</td>
					<td class="text-right" style="width: 45%;">{{$route->updated_at}}</td>
				</tr>
			</tbody>
		</table>
		<div id="map" class="tw-h-96 tw-my-3 border"></div>
	</x-card>
@endsection

@push('scripts')
	<script>
		$(document).ready(function () {
			let stations = @json($route->stations);

			var map = L.map('map').setView([16.781838250331322, 96.16154535383613], 15);

			L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			let myIcon = L.icon({
				iconUrl: "{{asset('image/station_marker.png')}}",
				iconSize: [35, 35],
				iconAnchor: [20, 35],
				popupAnchor: [-3, -36],
			});

			stations.forEach(station => {
				L.marker([station.latitude, station.longitude], { icon: myIcon }).addTo(map)
					.bindPopup(`${station.title} - ${station.pivot.time}`)
					.openPopup();
			});
		});
	</script>
@endpush