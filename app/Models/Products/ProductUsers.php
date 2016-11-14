<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Products\ProductUsers
 *
 * @mixin \Eloquent
 */
class ProductUsers extends Model
{
	
	protected $guarded = ['id'];
	
	public function keys()
	{
		return $this->hasMany(ProductKeys::class, 'claimed_by', 'id');
	}
	
}
