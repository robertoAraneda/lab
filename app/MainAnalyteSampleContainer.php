<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainAnalyteSampleContainer extends Model
{
    protected $table = 'analyte_sample_containers';

    public function mainAnalyte()
    {
        return $this->belongsTo(MainAnalyte::class, 'main_analyte_id');
    }

    public function analyte()
    {
        return $this->belongsTo(Analyte::class, 'analyte_id');
    }

    public function sampleCollectionMethod()
    {
        return $this->belongsTo(SampleCollectionMethod::class, 'sample_collection_method_id');
    }

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_id');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
