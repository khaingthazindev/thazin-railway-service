<?php

namespace Database\Seeders;

use App\Repositories\StationRepository;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = Storage::get('json/station.json');
        if ($stations) {
            $stations = json_decode($stations, true);
            foreach ($stations as $station) {
                (new StationRepository())->create([
                    'slug' => Str::slug($station['title']) . '-' . Str::random(6),
                    'title' => $station['title'],
                    'description' => $station['description'],
                    'latitude' => $station['latitude'],
                    'longitude' => $station['longitude'],
                ]);
            }
        }
    }
}
