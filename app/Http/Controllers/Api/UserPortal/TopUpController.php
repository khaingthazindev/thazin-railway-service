<?php

namespace App\Http\Controllers\Api\UserPortal;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repositories\TopUpHistoryRepository;

class TopUpController extends Controller
{
    protected $repo;
    public function __construct(TopUpHistoryRepository $topUpHistoryRepository)
    {
        $this->repo = $topUpHistoryRepository;
    }
    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'mimes:jpg,jpeg,png,heic', 'max:5120'],
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::guard('users_api')->user();
            $wallet = $user->wallet;

            if (!$wallet) {
                throw new Exception('Wallet not found');
            }

            $image = $request->file('image');
            $image_name = Str::random(6) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put('top-up-history/' . $image_name, file_get_contents($image));

            $top_up_history = $this->repo->create([
                'trx_id' => 'TRX-' . Str::random(10),
                'wallet_id' => $wallet->id,
                'user_id' => $user->id,
                'amount' => $request->amount,
                'description' => $request->description,
                'image' => $image_name,
            ]);

            DB::commit();
            return ResponseService::success([
                'trx_id' => $top_up_history->trx_id,
            ], 'Successfully uploaded');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
