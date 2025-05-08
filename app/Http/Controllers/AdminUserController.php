<?php

namespace App\Http\Controllers;

use App\Repositories\AdminUserRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;

class AdminUserController extends Controller
{
   protected $repo;
   public function __construct(AdminUserRepository $adminUserRepository)
   {
      $this->repo = $adminUserRepository;
   }
   public function index()
   {
      return view('admin-user.index');
   }

   public function datatable(Request $request)
   {
      if ($request->ajax()) {
         return $this->repo->datatable($request);
      }
   }

   public function create()
   {
      return view('admin-user.create');
   }

   public function store(AdminUserStoreRequest $request)
   {
      try {
         $this->repo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
         ]);

         return redirect()->route('admin-user.index')->with('success', 'Successfully created');
      } catch (\Exception $e) {
         return back()->with('error', $e->getMessage());
      }
   }

   public function edit($id)
   {
      $admin_user = $this->repo->find($id);
      return view('admin-user.edit', compact('admin_user'));
   }

   public function update(AdminUserUpdateRequest $request, $id)
   {
      try {
         $this->repo->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $this->repo->find($id)->password,
         ], $id);

         return redirect()->route('admin-user.index')->with('success', 'Successfully updated');
      } catch (\Exception $e) {
         return back()->with('error', $e->getMessage());
      }
   }

   public function destroy($id)
   {
      try {
         $this->repo->delete($id);

         return ResponseService::success([], 'Successfully deleted');
      } catch (\Exception $e) {
         return ResponseService::fail($e->getMessage());
      }
   }
}
