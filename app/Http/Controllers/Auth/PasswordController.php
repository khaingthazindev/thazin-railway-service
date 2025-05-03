<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\ChangePasswordRequest;

class PasswordController extends Controller
{
   public function edit(Request $request)
   {
      return view("profile.change-password", [
         'user' => $request->user(),
      ]);
   }

   public function update(ChangePasswordRequest $request): RedirectResponse
   {
      try {
         $request->user()->update([
            'password' => Hash::make($request->password),
         ]);

         return back()->with('status', 'password-updated');
      } catch (\Exception $e) {
         return back()->with("error", $e->getMessage());
      }
   }
}
