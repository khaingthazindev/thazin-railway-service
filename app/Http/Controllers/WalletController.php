<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use App\Repositories\WalletRepository;
use App\Http\Requests\WalletAddAmountStoreRequest;

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

    public function addAmount()
    {
        $selected_wallet = old('wallet_id') ? $this->repo->find(old('wallet_id')) : null;
        return view('wallet.add-amount', compact('selected_wallet'));
    }

    public function addAmountStore(WalletAddAmountStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            WalletService::addAmount([
                'wallet_id' => $request->wallet_id,
                'sourceable_id' => null,
                'sourceable_type' => null,
                'type' => 'manual',
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            DB::commit();

            return redirect()->route('wallet.index')->with('success', 'Successfully added amount.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput()->withInput();
        }
    }
}
