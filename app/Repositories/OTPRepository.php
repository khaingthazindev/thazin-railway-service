<?php
namespace App\Repositories;

use App\Models\OTP;
use App\Notifications\TwoStepVerification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Repositories\Contracts\BaseRepository;

class OTPRepository implements BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = OTP::class;
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

	public function generateOTP()
	{
		if (config('app.env') === 'production') {
			$code = str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
		} else {
			$code = '123456';
		}

		return $code;
	}

	public function send($email)
	{
		$otp = $this->model::where('email', $email)->where('expire_at', '>', date('Y-m-d H:i:s'))->first();
		if (!$otp) {
			$otp = $this->create([
				'email' => $email,
				'code' => $this->generateOTP(),
				'expire_at' => now()->addMinutes(5)->format('Y-m-d H:i:s'),
			]);

			$otp = $this->update([
				'token' => encrypt(['uuid' => Str::uuid(), 'email' => $otp->email]),
			], $otp->id);

			if (config('app.env') === 'production') {
				Notification::route('mail', $otp->email)->notify(new TwoStepVerification($otp));
			}
		}
		return $otp;
	}

	public function resend($otp_token)
	{
		$otp = $this->model::where('token', $otp_token)->first();

		if (!$otp) {
			throw new \Exception('The given data is invalid.');
		}

		if ($otp->expire_at > date('Y-m-d H:i:s')) {
			throw new \Exception('We have already sent OTP to ' . $otp->email . '. The OTP will expire in ' . now()->diff($otp->expire_at)->format('%i minutes and %s seconds.'));
		}

		$this->delete($otp->id);

		$decrypted_otp_token = decrypt($otp_token);
		$email = $decrypted_otp_token['email'];
		$otp = $this->create([
			'email' => $email,
			'code' => $this->generateOTP(),
			'token' => encrypt(['uuid' => Str::uuid(), 'email' => $email]),
			'expire_at' => now()->addMinutes(5)->format('Y-m-d H:i:s'),
		]);

		if (config('app.env') === 'production') {
			Notification::route('mail', $email)->notify(new TwoStepVerification($otp));
		}

		return $otp;
	}

	public function verify($otp_token, $code)
	{
		$otp = $this->model::where('token', $otp_token)->first();

		if (!$otp) {
			throw new \Exception('The given data is invalid.');
		}

		if ($otp->expire_at < date('Y-m-d H:i:s')) {
			throw new \Exception('The OTP code has expired.');
		}

		if ($otp->code !== $code) {
			throw new \Exception('The OTP code is invalid.');
		}

		$this->delete($otp->id);

		return true;
	}
}