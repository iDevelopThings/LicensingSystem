<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Products\ProductKeys
 *
 * @mixin \Eloquent
 */
class ProductKeys extends Model
{
	
	protected $guarded = ['id'];
	protected $dates = ['created_at', 'updated_at', 'claimed_at'];
	
	public function claimedBy()
	{
		return $this->hasOne(ProductUsers::class, 'id', 'claimed_by');
	}
	
	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id', 'id');
	}
	
}
