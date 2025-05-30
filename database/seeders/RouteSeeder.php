<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\RouteRepository;
use App\Repositories\StationRepository;
use Illuminate\Support\Facades\Storage;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $routes = Storage::get('json/route.json');
            if ($routes) {
                $routes = json_decode($routes, true);
                foreach ($routes as $route) {
                    $model = (new RouteRepository())->create([
                        'slug' => Str::slug($route['title']) . '-' . Str::random(6),
                        'title' => $route['title'],
                        'description' => $route['description'],
                        'direction' => $route['direction'],
                    ]);
                    $time = Carbon::parse($route['departure_time']);
                    $data = Arr::mapWithKeys($route['station_ids'], function ($station_id) use (&$time) {
                        $data = [
                            $station_id => [
                                'time' => $time->format('H:i:s'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]
                        ];
                        $time->addMinutes(5);
                        return $data;
                    });
                    $model->stations()->sync($data);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
        }

    }
}
