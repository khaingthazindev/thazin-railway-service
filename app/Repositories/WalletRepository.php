<?php
namespace App\Repositories;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class WalletRepository implements BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = Wallet::class;
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

	public function firstOrCreate(array $data1, array $data2)
	{
		$model = $this->model::firstOrCreate($data1, $data2);
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

	public function addAmount($wallet_id, $amount)
	{
		$model = $this->model::lockForUpdate()->findOrFail($wallet_id);
		$model->increment('amount', $amount);
		return $model;
	}

	public function reduceAmount($wallet_id, $amount)
	{
		$model = $this->model::lockForUpdate()->findOrFail($wallet_id);
		if ($model->amount < $amount) {
			throw new \Exception('Insufficient amount');
		}
		$model->decrement('amount', $amount);
		return $model;
	}
}