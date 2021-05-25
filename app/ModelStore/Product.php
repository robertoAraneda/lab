<?php

namespace App\ModelStore;

use App\State;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'products';

  public function createdUser()
  {
    return $this->belongsTo(User::class, 'created_user_id');
  }

  public function updatedUser()
  {
    return $this->belongsTo(User::class, 'updated_user_id');
  }

  public function presentation()
  {
    return $this->belongsTo(Presentation::class, 'presentation_id');
  }

  public function ubication()
  {
    return $this->belongsTo(Ubication::class, 'ubication_id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function state()
  {
    return $this->belongsTo(State::class, 'state_id');
  }
}
