<?php

namespace App\Http\Controllers;

use App\Repositories\StationRepository;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use App\Repositories\RouteRepository;
use App\Http\Requests\RouteStoreRequest;
use App\Http\Requests\RouteUpdateRequest;
use App\Repositories\RouteStationRepository;

class RouteController extends Controller
{
    protected $repo, $routeStationRepo;
    public function __construct(RouteRepository $routeRepository, RouteStationRepository $routeStationRepo)
    {
        $this->repo = $routeRepository;
        $this->routeStationRepo = $routeStationRepo;
    }
    public function index()
    {
        return view('route.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->repo->datatable($request);
        }
    }

    public function show($id)
    {
        $route = $this->repo->find($id);
        return view('route.show', compact('route'));
    }

    public function create()
    {
        $schedules = [];
        if (old('schedule')) {
            $schedules = array_map(function ($schedule) {
                $station = (new StationRepository())->find($schedule['station_id']);
                return [
                    'station_id' => $schedule['station_id'],
                    'title' => $station->title,
                    'time' => $schedule['time'],
                ];
            }, old('schedule'));
        }
        return view('route.create', compact('schedules'));
    }

    public function store(RouteStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $route = $this->repo->create([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'direction' => $request->direction,
            ]);
            $data = collect($request->schedule)->mapWithKeys(function ($schedule) {
                return [
                    $schedule['station_id'] => [
                        'time' => $schedule['time'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ];
            });
            $route->stations()->sync($data);

            DB::commit();
            return redirect()->route('route.index')->with('success', 'Successfully created');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $schedules = [];
        if (old('schedule')) {
            $schedules = array_map(function ($schedule) {
                $station = (new StationRepository())->find($schedule['station_id']);
                return [
                    'station_id' => $schedule['station_id'],
                    'title' => $station->title,
                    'time' => $schedule['time'],
                ];
            }, old('schedule'));
        } else {
            $stations = $this->repo->find($id)->stations->toArray();
            $schedules = array_map(function ($station) {
                return [
                    'station_id' => $station['id'],
                    'title' => $station['title'],
                    'time' => $station['pivot']['time'],
                ];
            }, $stations);
        }
        $route = $this->repo->find($id);

        return view('route.edit', compact('route', 'schedules'));
    }

    public function update(RouteUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $route = $this->repo->update([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'direction' => $request->direction,
            ], $id);
            $data = collect($request->schedule)->mapWithKeys(function ($schedule) {
                return [
                    $schedule['station_id'] => [
                        'time' => $schedule['time'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ];
            });
            $route->stations()->sync($data);

            DB::commit();
            return redirect()->route('route.index')->with('success', 'Successfully updated');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->repo->delete($id);
            $this->routeStationRepo->deleteByRouteId($id);

            DB::commit();
            return ResponseService::success([], 'Successfully deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
