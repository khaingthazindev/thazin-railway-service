<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $wallet_transaction = $this->repo->find($id);
        return view('top-up-history.show', compact('wallet_transaction'));
    }
}
