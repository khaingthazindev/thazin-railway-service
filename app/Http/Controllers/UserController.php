<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
   protected $repo;
   protected $walletRepo;
   public function __construct(UserRepository $userRepository, WalletRepository $walletRepo)
   {
      $this->repo = $userRepository;
      $this->walletRepo = $walletRepo;
   }
   public function index()
   {
      return view('user.index');
   }

   public function datatable(Request $request)
   {
      if ($request->ajax()) {
         return $this->repo->datatable($request);
      }
   }

   public function create()
   {
      return view('user.create');
   }

   public function store(UserStoreRequest $request)
   {
      try {
         $user = $this->repo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
         ]);

         $this->walletRepo->firstOrCreate(
            ['user_id' => $user->id],
            ['amount' => 0]
         );

         return redirect()->route('user.index')->with('success', 'Successfully created');
      } catch (\Exception $e) {
         return back()->with('error', $e->getMessage())->withInput();
      }
   }

   public function edit($id)
   {
      $user = $this->repo->find($id);
      return view('user.edit', compact('user'));
   }

   public function update(UserUpdateRequest $request, $id)
   {
      try {
         $this->repo->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $this->repo->find($id)->password,
         ], $id);

         return redirect()->route('user.index')->with('success', 'Successfully updated');
      } catch (\Exception $e) {
         return back()->with('error', $e->getMessage())->withInput();
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
