<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProductController extends Controller
{
	
	/**
	 * Viewing of a single product
	 *
	 * @param Request $request
	 * @param Product $product
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function viewProduct(Request $request, Product $product)
	{
		return view('product.view_product', [
			'product' => $product,
		]);
	}
}
