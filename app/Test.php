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

    public function analytes()
    {
        return $this->belongsToMany(Analyte::class)->withTimestamps();
    }
    public function reference_range()
    {
        return $this->hasOne(ReferenceRange::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function method()
    {
        return $this->belongsTo(Method::class, 'method_id');
    }

      public function loinc()
    {
        return $this->belongsTo(Loinc::class, 'loinc_id');
    }


      public function infinity_test()
    {
        return $this->belongsTo(InfinityTest::class, 'infinity_test_id');
    }


      public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

}
