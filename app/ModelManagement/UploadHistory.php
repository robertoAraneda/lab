<?php

namespace App\ModelManagement;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UploadHistory extends Model
{
  protected $connection = 'mysqlGestion';
  protected $table = 'upload_histories';

  public function createdUser()
  {
    return $this->belongsTo(User::class, 'created_user_id');
  }


  public function updatedUser()
  {
    return $this->belongsTo(User::class, 'updated_user_id');
  }
}
