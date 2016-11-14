<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Products\Product;
use App\Models\Products\ProductKeys;
use App\Models\Products\ProductUsers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
	private $product = null;
	private $user = null;
	
	public function __construct(Request $request)
	{
		$this->product = Product::where('api_key', $request->api_key)->first();
		$this->user = $this->product->user;
	}
	
	/**
	 * Create a user
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @internal param Product $product
	 *
	 */
	public function createUser(Request $request)
	{
		if ($this->product->user_id != $this->user->id)
			return msg('You do not have permission to do this!', 500);
		
		ProductUsers::create([
			'name'       => $request->name,
			'email'      => $request->email,
			'user_id'    => $this->user->id,
			'token'      => str_random(),
			'product_id' => $this->product->id,
		]);
		
		return msg('User successfully created!', 200);
	}
	
	/**
	 * Takes a token in the url for the
	 * user that is activating the key
	 *
	 * @param Request $request
	 * @param         $key
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function activateKey(Request $request, $key)
	{
		$apiUser = ProductUsers::where('token', $request->token);
		if (!$apiUser->count())
			return msg('Invalid token', 500);
		$apiUser = $apiUser->first();
		
		$keyCheck = ProductKeys::where('key', $key);
		if (!$keyCheck->count())
			return msg('This is an invalid product key!', 500);
		
		$keyCheck = $keyCheck->first();
		
		if ($keyCheck->claimed_by != null)
			return msg('This key has already been activated!', 500);
		
		$keyCheck->claimed_by = $apiUser->id;
		$keyCheck->claimed_at = Carbon::now();
		
		if ($keyCheck->save())
			return msg('Key successfully activated!');
		else
			return msg('Failed to activate key!', 500);
		
	}
	
	public function keyInfo(Request $request, $key)
	{
		$keyCheck = ProductKeys::where('key', $key);
		if (!$keyCheck->count())
			return msg('This is an invalid product key!', 500);
		
		$keyCheck = $keyCheck->first();
		
		return [
			'id'              => $keyCheck->id,
			'key'             => $keyCheck->key,
			'claimed_user'    => [
				'id'    => $keyCheck->claimedBy->id,
				'name'  => $keyCheck->claimedBy->name,
				'email' => $keyCheck->claimedBy->email,
			],
			'claimed_at'      => $keyCheck->claimed_at,
			'claimed_at_diff' => $keyCheck->claimed_at->diffForHumans(),
			'product'         => [
				'id'          => $keyCheck->product->id,
				'name'        => $keyCheck->product->name,
				'description' => $keyCheck->product->description,
			],
		];
		
	}
}
