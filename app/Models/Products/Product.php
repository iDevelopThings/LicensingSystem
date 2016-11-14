<?php

namespace App\Models\Products;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Products\Product
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
	protected $guarded = ['id'];
	
	public function keys()
	{
		return $this->hasMany(ProductKeys::class, 'product_id', 'id');
	}
	
	public function users()
	{
		return $this->hasMany(ProductUsers::class, 'product_id', 'id');
	}
	
	public function user()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}
	
}
