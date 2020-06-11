<?php

namespace App\ModelStore;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MovementProduct extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'movement_products';

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }


  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }
}
