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

    public function referenceRanges()
    {
        return $this->hasMany(ReferenceRange::class, 'test_id');
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


    public function infinityTest()
    {
        return $this->belongsTo(InfinityTest::class, 'infinity_test_id');
    }


    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
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
