<?php

namespace App\ModelManagement;

use Illuminate\Database\Eloquent\Model;

class PresidencyConsolidate extends Model
{
    protected $connection = 'mysqlGestion';
    protected $table = 'presidency_consolidates';
}
