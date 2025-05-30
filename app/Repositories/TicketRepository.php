<?php
namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class TicketRepository implements BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = Ticket::class;
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
		$model = $this->model::with(['user:id,name,email']);

		return DataTables::eloquent($model)
			->addColumn('user_name', function ($row) {
				return $row->user ? ("{$row->user->name} ({$row->user->email})") : '';
			})
			->editColumn('type', function ($row) {
				return '<span style="color: ' . $row->acsr_type["color"] . '">' . $row->acsr_type["text"] . '</span>';
			})
			->editColumn('direction', function ($row) {
				return '<span style="color: ' . $row->acsr_direction["color"] . '">' . $row->acsr_direction["text"] . '</span>';
			})
			->editColumn('price', function ($row) {
				return number_format($row->price);
			})
			->editColumn('created_at', function ($row) {
				return $row->created_at->format('Y-m-d H:i:s');
			})
			->editColumn('updated_at', function ($row) {
				return $row->updated_at->format('Y-m-d H:i:s');
			})
			->addColumn('action', function ($row) {
				return view('ticket._action', [
					'ticket' => $row,
				]);
			})
			->addColumn('responsive-icon', function ($row) {
				return '';
			})
			->rawColumns(['type', 'direction'])
			->filterColumn('user_name', function ($query, $keyword) {
				$query->whereHas('user', function ($q1) use ($keyword) {
					$q1->where('name', 'like', "%{$keyword}%")
						->orWhere('email', 'like', "%{$keyword}%");
				});
			})
			->toJson();
	}
}