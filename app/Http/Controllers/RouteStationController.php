<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Repositories\RouteStationRepository;
use App\Http\Requests\RouteStationStoreRequest;
use App\Http\Requests\RouteStationUpdateRequest;

class RouteStationController extends Controller
{
    protected $repo;
    public function __construct(RouteStationRepository $routeStationRepository)
    {
        $this->repo = $routeStationRepository;
    }
    public function index()
    {
        return view('routeStation.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->repo->datatable($request);
        }
    }

    public function show($id)
    {
        $routeStation = $this->repo->find($id);
        return view('routeStation.show', compact('routeStation'));
    }

    public function create()
    {
        return view('routeStation.create');
    }

    public function store(RouteStationStoreRequest $request)
    {
        try {
            $location = explode(',', $request->location);
            $this->repo->create([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);

            return redirect()->routeStation('routeStation.index')->with('success', 'Successfully created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $routeStation = $this->repo->find($id);
        return view('routeStation.edit', compact('routeStation'));
    }

    public function update(RouteStationUpdateRequest $request, $id)
    {
        try {
            $location = explode(',', $request->location);
            $this->repo->update([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ], $id);

            return redirect()->routeStation('routeStation.index')->with('success', 'Successfully updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->repo->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (\Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
