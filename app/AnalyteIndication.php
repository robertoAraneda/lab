<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyteIndication extends Model
{
    protected $table = 'analyte_label';

    public function analyte(){
        return $this->belongsTo(Analyte::class, 'analyte_id');
    }

    public function indication(){
        return $this->belongsTo(Indication::class, 'indication_id');
    }
}
