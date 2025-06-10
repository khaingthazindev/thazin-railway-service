<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\StationDetailResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StationResource;
use App\Repositories\StationRepository;

class StationController extends Controller
{
    protected $repo;
    public function __construct(StationRepository $stationRepository)
    {
        $this->repo = $stationRepository;
    }

    public function index(Request $request)
    {
        $stations = $this->repo->queryByAll()
            ->when($request->search, function ($q1) use ($request) {
                $q1->where('title', 'like', "%{$request->search}%");
                $q1->orWhere('description', 'like', "%{$request->search}%");
                $q1->orWhere('created_at', 'like', "%{$request->search}%");
            })
            ->paginate(10);

        return StationResource::collection($stations)->additional(['message' => 'success']);
    }

    public function show($slug)
    {
        $station = $this->repo->queryBySlug($slug)
            ->with(['routes'])
            ->firstOrFail();

        return ResponseService::success(new StationDetailResource($station));
    }
}
