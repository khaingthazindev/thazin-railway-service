<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Resources\UserPortal\ProfileResource;
use App\Services\ResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::guard('users_api')->user();

        return ResponseService::success(new ProfileResource($user));
    }
}
