<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketInspectorStoreRequest;
use App\Http\Requests\TicketInspectorUpdateRequest;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use App\Repositories\TicketInspectorRepository;

class TicketInspectorController extends Controller
{
   protected $repo;
   public function __construct(TicketInspectorRepository $ticketInpectorRepository)
   {
      $this->repo = $ticketInpectorRepository;
   }
   public function index()
   {
      return view('ticket-inspector.index');
   }

   public function datatable(Request $request)
   {
      if ($request->ajax()) {
         return $this->repo->datatable($request);
      }
   }

   public function create()
   {
      return view('ticket-inspector.create');
   }

   public function store(TicketInspectorStoreRequest $request)
   {
      try {
         $this->repo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
         ]);

         return redirect()->route('ticket-inspector.index')->with('success', 'Successfully created');
      } catch (\Exception $e) {
         return back()->with('error', $e->getMessage());
      }
   }

   public function edit($id)
   {
      $ticket_inspector = $this->repo->find($id);
      return view('ticket-inspector.edit', compact('ticket_inspector'));
   }

   public function update(TicketInspectorUpdateRequest $request, $id)
   {
      try {
         $this->repo->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $this->repo->find($id)->password,
         ], $id);

         return redirect()->route('ticket-inspector.index')->with('success', 'Successfully updated');
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
