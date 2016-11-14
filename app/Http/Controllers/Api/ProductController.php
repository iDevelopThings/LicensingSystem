<?php

namespace App\Http\Controllers\Api;

use App\Models\Products\Product;
use App\Models\Products\ProductKeys;
use App\Models\Products\ProductUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Psy\Test\Exception\RuntimeExceptionTest;

class ProductController extends Controller
{
	/**
	 * Create a new product, pass "title" and "description"
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create(Request $request)
	{
		Product::create([
			'title'       => $request->title,
			'description' => $request->description,
			'user_id'     => $request->user()->id,
		]);
		
		return msg('Successfully created product!');
	}
	
	/**
	 * Get a list of the users products, paginate-able "?page=1"
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getProducts(Request $request)
	{
		$products = Product::where('user_id', $request->user()->id)
			->orderBy('id', 'DESC')
			->paginate(20);
		
		if (!$products->count())
			return msg('You have no products!', 500);
		
		return response()->json($products);
	}
	
	/**
	 * Deletes a product
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteProduct(Request $request, Product $product)
	{
		if ($product->user_id != $request->user()->id)
			return msg("You do not have permission to do this!", 500);
		
		if ($product->delete())
			return msg('Successfully deleted');
		else
			return msg("Failed to delete!", 500);
	}
	
	/**
	 * Create a product api key
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createApiKey(Request $request, Product $product)
	{
		if ($product->user_id != $request->user()->id)
			return msg("You do not have permission to do this!", 500);
		
		$product->api_key = str_random();
		if ($product->save())
			return response()->json(['message' => 'Successfully set product api key!', 'api_key' => $product->api_key]);
		else
			return msg('Failed to set product api key!', 500);
		
	}
	
	/**
	 * Get product information
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getProductInfo(Request $request, Product $product)
	{
		if ($product->user_id != $request->user()->id)
			return msg("You do not have permission to do this!", 500);
		
		$product->key_count = $product->keys()->count();
		$product->user_count = $product->users()->count();
		
		return response()->json($product);
	}
	
	/**
	 * Create a new user for the product
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createUser(Request $request, Product $product)
	{
		if ($product->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		ProductUsers::create([
			'name'       => $request->name,
			'email'      => $request->email,
			'user_id'    => $request->user()->id,
			'token'      => str_random(),
			'product_id' => $product->id,
		]);
		
		return msg('User successfully created!', 200);
	}
	
	/**
	 * Gets a list of project specific users
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getUsers(Request $request, Product $product)
	{
		if ($product->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		$users = ProductUsers::where(['user_id' => $request->user()->id, 'product_id' => $product->id])->paginate(20);
		
		return response()->json($users);
	}
	
	/**
	 * Delete a user from a product
	 *
	 * @param Request      $request
	 * @param Product      $product
	 * @param ProductUsers $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteUser(Request $request, Product $product, ProductUsers $user)
	{
		if ($product->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		if ($user->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		if ($user->product_id != $product->id)
			return msg('User is not a part of this product!', 500);
		
		if ($user->delete())
			return msg('Successfully deleted user!');
		else
			return msg('Failed to delete user!', 500);
		
	}
	
	/**
	 * Get the users information
	 *
	 * @param Request      $request
	 * @param ProductUsers $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getUser(Request $request, Product $product, ProductUsers $user)
	{
		if ($user->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		if ($user->product_id != $product->id)
			return msg('User is not a part of this product!', 500);
		
		$returnData = [
			'user' => [
				'id'         => $user->id,
				'name'       => $user->name,
				'email'      => $user->email,
				'created_at' => $user->created_at->diffForHumans(),
			],
			'keys' => $user->keys->map(function ($item)
			{
				return [
					'key'             => $item->key,
					'claimed_at'      => $item->claimed_at,
					'claimed_at_diff' => $item->claimed_at->diffForHumans(),
				];
			}),
		];
		
		return response()->json($returnData);
		
	}
	
	/**
	 * Create a new product key
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createKey(Request $request, Product $product)
	{
		if ($product->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		ProductKeys::create([
			'user_id'    => $request->user()->id,
			'product_id' => $product->id,
			'key'        => str_random(),
		]);
		
		return msg('Key successfully created!', 200);
	}
	
	/**
	 * Get products keys
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getKeys(Request $request, Product $product)
	{
		if ($product->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		$users = ProductKeys::where(['user_id' => $request->user()->id, 'product_id' => $product->id])->paginate(20);
		
		return response()->json($users);
	}
	
	/**
	 * Delete a key from a product
	 *
	 * @param Request     $request
	 * @param Product     $product
	 * @param ProductKeys $key
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteKey(Request $request, Product $product, ProductKeys $key)
	{
		if ($product->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		if ($key->user_id != $request->user()->id)
			return msg('You do not have permission to do this!', 500);
		
		if ($key->product_id != $product->id)
			return msg('User is not a part of this product!', 500);
		
		if ($key->delete())
			return msg('Successfully deleted key!');
		else
			return msg('Failed to delete key!', 500);
		
	}
	
}
