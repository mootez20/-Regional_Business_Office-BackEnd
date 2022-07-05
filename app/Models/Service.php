<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Service extends Model
{
  protected $fillable = ['name', 'type', 'description', 'city_id'];

  public function city()
  {
    return $this->belongsTo(City::class);
  }
}
