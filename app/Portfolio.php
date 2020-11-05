<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    protected $fillable = ['title','img','alias','text','customer','keywords','meta_desc','filter_alias'];

    public function filter(){

        return $this->belongsTo('App\Filter', 'filter_alias', 'alias');
    }
}
