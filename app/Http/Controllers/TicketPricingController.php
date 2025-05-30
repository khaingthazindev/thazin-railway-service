<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Repositories\TicketPricingRepository;
use App\Http\Requests\TicketPricingStoreRequest;
use App\Http\Requests\TicketPricingUpdateRequest;

class TicketPricingController extends Controller
{
    protected $repo;
    public function __construct(TicketPricingRepository $ticketPricingRepository)
    {
        $this->repo = $ticketPricingRepository;
    }
    public function index()
    {
        return view('ticket-pricing.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->repo->datatable($request);
        }
    }

    public function show($id)
    {
        $ticket_pricing = $this->repo->find($id);
        return view('ticket-pricing.show', compact('ticket-pricing'));
    }

    public function create()
    {
        return view('ticket-pricing.create');
    }

    public function store(TicketPricingStoreRequest $request)
    {
        try {
            $period = explode(' - ', $request->period);
            $this->repo->create([
                'type' => $request->type,
                'price' => $request->price,
                'offer_quantity' => $request->offer_quantity,
                'remain_quantity' => $request->offer_quantity,
                'started_at' => $period[0],
                'ended_at' => $period[1],
            ]);

            return redirect()->route('ticket-pricing.index')->with('success', 'Successfully created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $ticket_pricing = $this->repo->find($id);
        return view('ticket-pricing.edit', compact('ticket_pricing'));
    }

    public function update(TicketPricingUpdateRequest $request, $id)
    {
        try {
            $period = explode(' - ', $request->period);

            $ticket_pricing = $this->repo->find($id);
            $old_offer_quantity = $ticket_pricing->offer_quantity;
            $old_remain_quantity = $ticket_pricing->remain_quantity;
            $already_sale = $old_offer_quantity - $old_remain_quantity;
            $new_offer_quantity = $request->offer_quantity;
            $new_remain_quantity = $new_offer_quantity - $already_sale;
            if ($new_remain_quantity < 0) {
                throw new \Exception("You already sale more than you offer limit.");
            }

            $this->repo->update([
                'type' => $request->type,
                'price' => $request->price,
                'offer_quantity' => $new_offer_quantity,
                'remain_quantity' => $new_remain_quantity,
                'started_at' => $period[0],
                'ended_at' => $period[1],
            ], $id);

            return redirect()->route('ticket-pricing.index')->with('success', 'Successfully updated');
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
