<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class UserRepository implements BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = User::class;
	}

	public function find($id)
	{
		$model = $this->model::find($id);
		return $model;
	}

	public function findByEmail($email)
	{
		$model = $this->model::where('email', $email)->first();
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
			->editColumn('email_verified_at', function ($row) {
				return $row->email_verified_at?->format('Y-m-d H:i:s');
			})
			->editColumn('created_at', function ($row) {
				return $row->created_at->format('Y-m-d H:i:s');
			})
			->editColumn('updated_at', function ($row) {
				return $row->updated_at->format('Y-m-d H:i:s');
			})
			->addColumn('action', function ($row) {
				return view('user._action', [
					'user' => $row,
				]);
			})
			->addColumn('responsive-icon', function ($row) {
				return '';
			})
			->toJson();
	}
}