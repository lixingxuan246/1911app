<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    //
    protected $table = 'api-user';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
