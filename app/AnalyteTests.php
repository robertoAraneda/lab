<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyteTests extends Model
{

    protected $table = 'analyte_test';

    public function analyte()
    {
        return $this->belongsTo(Analyte::class, 'analyte_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

}
