<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;

class AdminUserController extends Controller
{
   public function index()
   {
      return view('admin-user.index');
   }

   public function datatable(Request $request)
   {
      if ($request->ajax()) {
         $model = AdminUser::query();

         return DataTables::eloquent($model)
            ->editColumn('created_at', function ($row) {
               return $row->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
               return $row->updated_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($row) {
               return view('admin-user._action', [
                  'admin_user' => $row,
               ]);
            })
            ->addColumn('responsive-icon', function ($row) {
               return '';
            })
            ->toJson();
      }
   }

   public function create()
   {
      return view('admin-user.create');
   }

   public function store(AdminUserStoreRequest $request)
   {
      try {
         AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
         ]);
         return redirect()->route('admin-user.index')->with('success', 'Successfully created');
      } catch (\Exception $e) {
         return back()->with('error', $e->getMessage());
      }
   }

   public function edit(AdminUser $admin_user)
   {
      return view('admin-user.edit', compact('admin_user'));
   }

   public function update(AdminUserUpdateRequest $request, AdminUser $admin_user)
   {
      try {
         $admin_user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin_user->password,
         ]);
         return redirect()->route('admin-user.index')->with('success', 'Successfully updated');
      } catch (\Exception $e) {
         return back()->with('error', $e->getMessage());
      }
   }

   public function destroy(AdminUser $admin_user)
   {
      try {
         $admin_user->delete();

         return ResponseService::success([], 'Successfully deleted');
      } catch (\Exception $e) {
         return ResponseService::fail($e->getMessage());
      }
   }
}
