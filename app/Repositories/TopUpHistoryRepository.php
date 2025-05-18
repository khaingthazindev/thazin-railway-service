<?php
namespace App\Repositories;

use App\Models\TopUpHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class TopUpHistoryRepository implements BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = TopUpHistory::class;
	}

	public function find($id)
	{
		$model = $this->model::with(['user:id,name,email'])->find($id);
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
	}

	public function datatable(Request $request)
	{
		$model = $this->model::with(['user:id,name,email']);

		return DataTables::eloquent($model)
			->addColumn('user_name', function ($row) {
				return $row->user ? ("{$row->user->name} ({$row->user->email})") : '';
			})
			->editColumn('amount', function ($row) {
				return number_format($row->amount);
			})
			->editColumn('image', function ($row) {
				return '<img src="' . $row->image_url . '" alt="" class="tw-w-10 tw-rounded">';
			})
			->editColumn('status', function ($row) {
				return '<span style="color: ' . $row->status["color"] . '">' . $row->status["text"] . '</span>';
			})
			->editColumn('created_at', function ($row) {
				return $row->created_at->format('Y-m-d H:i:s');
			})
			->editColumn('updated_at', function ($row) {
				return $row->updated_at->format('Y-m-d H:i:s');
			})
			->addColumn('action', function ($row) {
				return view('top-up-history._action', [
					'top_up_history' => $row,
				]);
			})
			->addColumn('responsive-icon', function ($row) {
				return '';
			})
			->rawColumns(['image', 'status'])
			->filterColumn('user_name', function ($query, $keyword) {
				$query->whereHas('user', function ($q1) use ($keyword) {
					$q1->where('name', 'like', "%{$keyword}%")
						->orWhere('email', 'like', "%{$keyword}%");
				});
			})
			->toJson();
	}
}