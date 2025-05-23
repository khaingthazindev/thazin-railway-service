<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use App\Repositories\WalletRepository;
use App\Repositories\StationRepository;
use App\Http\Requests\StationStoreRequest;
use App\Http\Requests\StationUpdateRequest;

class StationController extends Controller
{
    protected $repo;
    protected $walletRepo;
    public function __construct(StationRepository $stationRepository, WalletRepository $walletRepo)
    {
        $this->repo = $stationRepository;
        $this->walletRepo = $walletRepo;
    }
    public function index()
    {
        return view('station.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->repo->datatable($request);
        }
    }

    public function create()
    {
        return view('station.create');
    }

    public function store(StationStoreRequest $request)
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

            return redirect()->route('station.index')->with('success', 'Successfully created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $station = $this->repo->find($id);
        return view('station.edit', compact('station'));
    }

    public function update(StationUpdateRequest $request, $id)
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

            return redirect()->route('station.index')->with('success', 'Successfully updated');
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
