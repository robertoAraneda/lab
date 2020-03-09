<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleCollectionMethod extends Model
{

    protected $table = 'collection_method_sample';

    public function sample(){
        return $this->belongsTo(Sample::class, 'sample_id');

    }

    public function collectionMethod(){
        return $this->belongsTo(CollectionMethod::class, 'collection_method_id');
    }
}
