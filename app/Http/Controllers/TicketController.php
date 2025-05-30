<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Repositories\TicketRepository;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\TicketUpdateRequest;

class TicketController extends Controller
{
    protected $repo;
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->repo = $ticketRepository;
    }
    public function index()
    {
        return view('ticket.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->repo->datatable($request);
        }
    }

    public function show($id)
    {
        $ticket = $this->repo->find($id);
        return view('ticket.show', compact('ticket'));
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(TicketStoreRequest $request)
    {
        try {
            $location = explode(',', $request->location);
            $this->repo->create([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);

            return redirect()->route('ticket.index')->with('success', 'Successfully created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $ticket = $this->repo->find($id);
        return view('ticket.edit', compact('ticket'));
    }

    public function update(TicketUpdateRequest $request, $id)
    {
        try {
            $location = explode(',', $request->location);
            $this->repo->update([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ], $id);

            return redirect()->route('ticket.index')->with('success', 'Successfully updated');
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
