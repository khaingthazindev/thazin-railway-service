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
		$model = $this->model::with(['user:id,name,email', 'sourceable'])->find($id);
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
		$model = $this->model::with(['user:id,name,email']);

		return DataTables::eloquent($model)
			->addColumn('user_name', function ($row) {
				return $row->user ? ("{$row->user->name} ({$row->user->email})") : '';
			})
			->editColumn('method', function ($row) {
				return '<span style="color: ' . $row->method["color"] . '">' . $row->method["text"] . '</span>';
			})
			->editColumn('type', function ($row) {
				return '<span style="color: ' . $row->type["color"] . '">' . $row->type["text"] . '</span>';
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
			->addColumn('action', function ($row) {
				return view('wallet-transaction._action', [
					'wallet_transaction' => $row,
				]);
			})
			->addColumn('responsive-icon', function ($row) {
				return '';
			})
			->rawColumns(['method', 'type'])
			->filterColumn('user_name', function ($query, $keyword) {
				$query->whereHas('user', function ($q1) use ($keyword) {
					$q1->where('name', 'like', "%{$keyword}%")
						->orWhere('email', 'like', "%{$keyword}%");
				});
			})
			->toJson();
	}

	public function queryByUser($user)
	{
		return $this->model::where('user_id', $user->id);
	}
}