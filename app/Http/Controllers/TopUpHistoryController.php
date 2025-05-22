<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use App\Repositories\TopUpHistoryRepository;

class TopUpHistoryController extends Controller
{
    protected $repo;
    public function __construct(TopUpHistoryRepository $topUpHistoryRepository)
    {
        $this->repo = $topUpHistoryRepository;
    }
    public function index()
    {
        return view('top-up-history.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->repo->datatable($request);
        }
    }

    public function show($id)
    {
        $top_up_history = $this->repo->find($id);
        return view('top-up-history.show', compact('top_up_history'));
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $this->repo->approve($id);

            DB::commit();
            return ResponseService::success([], 'Successfully approved');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            $this->repo->reject($id);

            return ResponseService::success([], 'Successfully rejected');
        } catch (\Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
