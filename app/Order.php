<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected   $guarded   = [];

    public function endpoint()
    {
        return $this->hasOne('App\Endpoint', 'id', 'endpoint_id')->first();
    }

    public function source_type()
    {
        return $this->hasOne('App\SourceType', 'id', 'source_type_id')->first();
    }
}
