<?php

namespace App\Http\Controllers;

use App\Repositories\WalletRepository;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $repo;
    public function __construct(WalletRepository $walletRepository)
    {
        $this->repo = $walletRepository;
    }
    public function index()
    {
        return view('wallet.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->repo->datatable($request);
        }
    }
}
