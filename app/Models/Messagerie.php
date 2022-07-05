<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Messagerie extends Model
{
    protected $fillable =['date_message','message','emetteur_id','recepteur_id'];

}
