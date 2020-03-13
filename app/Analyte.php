<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analyte extends Model
{
    public function tests()
    {
        return $this->belongsToMany(Test::class)->withPivot('order', 'created_user_id')->withTimestamps();
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class)->withTimestamps();
    }

    public function indications()
    {
        return $this->belongsToMany(Indication::class)->withPivot('order', 'created_user_id')->withTimestamps();
    }

    public function timeResponse()
    {
        return $this->belongsTo(TimeResponse::class, 'time_response_id');
    }

    public function medicalOrder()
    {
        return $this->belongsTo(MedicalOrder::class, 'medical_order_id');
    }

    public function fonasaTest(){
        return $this->belongsTo(FonasaTest::class, 'fonasa_test_id');
    }

    public function hcaLaboratory()
    {
        return $this->belongsTo(HcaLaboratory::class, 'hca_laboratory_id');
    }

    public function infinityLabdateTest()
    {
        return $this->belongsTo(InfinityLabdateTest::class, 'infinity_labdate_test_id');
    }

    public function available()
    {
        return $this->belongsTo(Available::class, 'available_id');
    }

    public function vihKey()
    {
        return $this->belongsTo(VihKey::class, 'vih_key_id');
    }

    public function loinc()
    {
        return $this->belongsTo(Loinc::class, 'loinc_id');
    }

    public function timeProcess()
    {
        return $this->belongsTo(TimeProcess::class, 'time_process_id');
    }

    public function timeReception()
    {
        return $this->belongsTo(TimeReception::class, 'time_reception_id');
    }

    public function workArea()
    {
        return $this->belongsTo(Workarea::class, 'workarea_id');
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

    public function analyteSampleContainer()
    {
        return $this->hasOne(MainAnalyteSampleContainer::class, 'analyte_id');
    }


}
