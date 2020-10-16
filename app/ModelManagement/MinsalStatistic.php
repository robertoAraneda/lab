<?php

namespace App\ModelManagement;

use Illuminate\Database\Eloquent\Model;

class MinsalStatistic extends Model
{
    protected $connection = 'mysqlGestion';
    protected $table = 'minsal_statistics';
        /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
