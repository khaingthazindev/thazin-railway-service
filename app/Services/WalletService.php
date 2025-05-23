<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;

class WalletService
{
	public static function addAmount(array $data)
	{
		// Wallet add mount 
		$wallet = (new WalletRepository())->addAmount($data['wallet_id'], $data['amount']);

		// Wallet transaction
		(new WalletTransactionRepository())->create([
			'trx_id' => 'TRX-' . Str::random(10),
			'wallet_id' => $data['wallet_id'],
			'user_id' => $wallet->user_id,
			'sourceable_id' => $data['sourceable_id'],
			'sourceable_type' => $data['sourceable_type'],
			'method' => 'add',
			'type' => $data['type'],
			'amount' => $data['amount'],
			'description' => $data['description'],
		]);
	}

	public static function reduceAmount(array $data)
	{
		// Wallet add mount 
		$wallet = (new WalletRepository())->reduceAmount($data['wallet_id'], $data['amount']);
		// Wallet transaction
		(new WalletTransactionRepository())->create([
			'trx_id' => 'TRX-' . Str::random(10),
			'wallet_id' => $data['wallet_id'],
			'user_id' => $wallet->user_id,
			'sourceable_id' => $data['sourceable_id'],
			'sourceable_type' => $data['sourceable_type'],
			'method' => 'reduce',
			'type' => $data['type'],
			'amount' => $data['amount'],
			'description' => $data['description'],
		]);
	}
}