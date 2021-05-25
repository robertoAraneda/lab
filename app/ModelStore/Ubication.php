<?php

namespace App\ModelStore;

use Illuminate\Database\Eloquent\Model;
use App\State;
use App\User;

class Ubication extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'ubications';

  public function createdUser()
  {
    return $this->belongsTo(User::class, 'created_user_id');
  }

  public function updatedUser()
  {
    return $this->belongsTo(User::class, 'updated_user_id');
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function state()
  {
    return $this->belongsTo(State::class, 'state_id');
  }
}
