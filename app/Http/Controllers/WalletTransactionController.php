<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\WalletTransactionRepository;

class WalletTransactionController extends Controller
{
    protected $repo;
    public function __construct(WalletTransactionRepository $walletTransactionRepository)
    {
        $this->repo = $walletTransactionRepository;
    }
    public function index()
    {
        return view('wallet-transaction.index');
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
        return view('wallet-transaction.show', compact('wallet_transaction'));
    }
}
