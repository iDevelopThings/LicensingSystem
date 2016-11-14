<?php

namespace App\Http\Middleware;

use App\Models\Products\Product;
use Closure;

class PublicApi
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		
		if (!$request->has('api_key'))
			return msg('No api_key set!', 500);
		
		$keyCheck = Product::where('api_key', $request->api_key);
		if (!$keyCheck->count())
			return msg('Invalid api_key!', 500);
		
		
		
		
		return $next($request);
	}
}
