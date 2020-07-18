<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenController extends Model
{
    //
    protected $table = 'api-token';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
