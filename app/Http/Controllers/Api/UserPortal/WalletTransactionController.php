<?php

namespace App\Http\Controllers\Api\UserPortal;

use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\WalletTransactionRepository;
use App\Http\Resources\UserPortal\WalletTransactionResource;
use App\Http\Resources\UserPortal\WalletTransactionDetailResource;

class WalletTransactionController extends Controller
{
    protected $walletTransactionRepository;
    public function __construct(WalletTransactionRepository $walletTransactionRepository)
    {
        $this->walletTransactionRepository = $walletTransactionRepository;
    }
    public function index(Request $request)
    {
        $user = Auth::guard('users_api')->user();
        $wallet_transactions = $this->walletTransactionRepository->queryByUser($user)
            ->with(['user:id,name,email', 'sourceable'])
            ->when($request->search, function ($q1) use ($request) {
                $q1->where('trx_id', 'like', "%{$request->search}%")
                    ->orWhere('amount', 'like', "%{$request->search}%")
                    ->orWhere('created_at', 'like', "%{$request->search}%");
            })
            ->orderByDesc('id')
            ->paginate(10);

        return WalletTransactionResource::collection($wallet_transactions)->additional(['message' => 'success']);
    }

    public function show($trx_id)
    {
        $user = Auth::guard('users_api')->user();
        $wallet_transaction = $this->walletTransactionRepository->queryByUser($user)
            ->with(['user:id,name,email', 'sourceable'])
            ->where('trx_id', $trx_id)
            ->firstOrFail();

        return ResponseService::success(new WalletTransactionDetailResource($wallet_transaction));
    }
}
