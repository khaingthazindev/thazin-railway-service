<?php
namespace App\Repositories;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TicketPricing;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class TicketPricingRepository implements BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = TicketPricing::class;
	}

	public function find($id)
	{
		$model = $this->model::find($id);
		return $model;
	}

	public function create(array $data)
	{
		$model = $this->model::create($data);
		return $model;
	}

	public function update(array $data, $id)
	{
		$model = $this->find($id);
		$model->update($data);
		return $model;
	}

	public function delete($id)
	{
		$model = $this->find($id);
		$model->delete();
		return $model;
	}

	public function datatable(Request $request)
	{
		$model = $this->model::query();

		return DataTables::eloquent($model)
			->editColumn('type', function ($row) {
				return '<span style="color: ' . $row->acsr_type["color"] . '">' . $row->acsr_type["text"] . '</span>';
			})
			->editColumn('direction', function ($row) {
				return '<span style="color: ' . $row->acsr_direction["color"] . '">' . $row->acsr_direction["text"] . '</span>';
			})
			->editColumn('price', function ($row) {
				return number_format($row->price);
			})
			->editColumn('offer_quantity', function ($row) {
				return number_format($row->offer_quantity);
			})
			->editColumn('remain_quantity', function ($row) {
				return number_format($row->remain_quantity);
			})
			->editColumn('started_at', function ($row) {
				return $row->started_at->format('Y-m-d H:i:s');
			})
			->editColumn('ended_at', function ($row) {
				return $row->ended_at->format('Y-m-d H:i:s');
			})
			->editColumn('created_at', function ($row) {
				return $row->created_at->format('Y-m-d H:i:s');
			})
			->editColumn('updated_at', function ($row) {
				return $row->updated_at->format('Y-m-d H:i:s');
			})
			->addColumn('action', function ($row) {
				return view('ticket-pricing._action', [
					'ticket_pricing' => $row,
				]);
			})
			->addColumn('responsive-icon', function ($row) {
				return '';
			})
			->rawColumns(['type', 'direction'])
			->toJson();
	}
}