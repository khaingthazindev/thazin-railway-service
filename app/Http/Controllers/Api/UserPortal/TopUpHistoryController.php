<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Resources\UserPortal\TopUpHistoryDetailResource;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TopUpHistoryRepository;
use App\Http\Resources\UserPortal\TopUpHistoryResource;

class TopUpHistoryController extends Controller
{
    protected $repo;
    public function __construct(TopUpHistoryRepository $topUpHistoryRepository)
    {
        $this->repo = $topUpHistoryRepository;
    }

    public function index(Request $request)
    {
        $user = Auth::guard('users_api')->user();
        $top_up_histories = $this->repo->queryByUser($user)
            ->with(['user:id,name,email'])
            ->when($request->search, function ($q1) use ($request) {
                $q1->where('trx_id', 'like', "%{$request->search}%")
                    ->orWhere('amount', 'like', "%{$request->search}%")
                    ->orWhere('created_at', 'like', "%{$request->search}%");
            })
            ->orderByDesc('id')
            ->paginate(10);

        return TopUpHistoryResource::collection($top_up_histories)->additional(['message' => 'success']);
    }

    public function show($trx_id)
    {
        $user = Auth::guard('users_api')->user();
        $top_up_history = $this->repo->queryByUser($user)
            ->with(['user:id,name,email'])
            ->where('trx_id', $trx_id)
            ->firstOrFail();

        return ResponseService::success(new TopUpHistoryDetailResource($top_up_history));
    }
}
