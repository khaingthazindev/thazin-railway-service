<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Station;
use Illuminate\Http\Request;

class Select2AjaxController extends Controller
{
    public function wallet(Request $request)
    {
        if ($request->ajax()) {
            $data = Wallet::with(['user'])
                ->when($request->search, function ($q1) use ($request) {
                    $q1->whereHas('user', function ($q2) use ($request) {
                        $q2->where('name', 'LIKE', '%' . $request->search . '%');
                    });
                })
                ->paginate(5);
            return response()->json($data);
        }
    }

    public function station(Request $request)
    {
        if ($request->ajax()) {
            $data = Station::select('id', 'title')
                ->when($request->search, function ($q1) use ($request) {
                    $q1->where('title', 'LIKE', '%' . $request->search . '%');
                })
                ->paginate(5);
            return response()->json($data);
        }
    }
}
