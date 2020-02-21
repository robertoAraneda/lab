<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainAnalyteSampleContainer extends Model
{
    protected $table = 'analyte_sample_containers';

    public function main_analyte(){
        return $this->belongsTo(MainAnalyte::class, 'main_analyte_id');
    }
    public function analyte(){
        return $this->belongsTo(Analyte::class, 'analyte_id');
    }
    public function sample_collection_method(){
        return $this->belongsTo(SampleCollectionMethod::class, 'sample_collection_method_id');
    }
    public function container(){
        return $this->belongsTo(Container::class, 'container_id');
    }
    public function created_user(){
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }
}
