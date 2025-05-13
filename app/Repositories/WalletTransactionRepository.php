<?php
namespace App\Repositories;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class WalletTransactionRepository implements BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = WalletTransaction::class;
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
	}

	public function delete($id)
	{
	}

	public function datatable(Request $request)
	{
		$model = $this->model::query();

		return DataTables::eloquent($model)
			->addColumn('user_name', function ($row) {
				return $row->user ? ("{$row->user->name} ({$row->user->email})") : '';
			})
			->editColumn('amount', function ($row) {
				return number_format($row->amount);
			})
			->editColumn('created_at', function ($row) {
				return $row->created_at->format('Y-m-d H:i:s');
			})
			->editColumn('updated_at', function ($row) {
				return $row->updated_at->format('Y-m-d H:i:s');
			})
			->addColumn('responsive-icon', function ($row) {
				return '';
			})
			->toJson();
	}
}