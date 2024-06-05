<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected   $guarded   = [];

    public function endpoint_type()
    {
        return $this->hasOne('App\EndpointType', 'id', 'endpoint_type_id')->first();
    }
}
