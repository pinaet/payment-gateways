<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endpoint extends Model
{
    use HasFactory;
    
    protected   $guarded   = [];

    public function endpoint_type()
    {
        return $this->hasOne('App\EndpointType', 'id', 'endpoint_type_id')->first();
    }
}
