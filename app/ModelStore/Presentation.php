<?php

namespace App\ModelStore;

use App\State;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{

    protected $connection = 'mysql2';
    protected $table = 'presentations';

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
