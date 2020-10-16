<?php

namespace App\ModelManagement;

use Illuminate\Database\Eloquent\Model;

class MinsalDetail extends Model
{
    protected $connection = 'mysqlGestion';
    protected $table = 'minsal_details';
         /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
