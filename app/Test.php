<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'description',
        'infinity_test_id',
        'loinc_id',
        'method_id',
        'unit_id',
        'state_id',
        'created_user_id'
    ];

    public function analytes(){
        return $this->belongsToMany(Analyte::class)->withTimestamps();
    }
    public function reference_range(){
        return $this->belongsTo(ReferenceRange::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
