<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyteLabel extends Model
{

    protected $table = 'analyte_label';

    public function analyte(){
        return $this->belongsTo(Analyte::class, 'analyte_id');
    }

    public function label(){
        return $this->belongsTo(Label::class, 'label_id');
    }
}
