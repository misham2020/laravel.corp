<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    public function filter(){

        return $this->belongsTo('App\Filter', 'filter_alias', 'alias');
    }
}
