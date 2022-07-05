<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Album extends Model
{
  protected $fillable = ['title', 'created_at', 'city_id'];

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function photos()
  {
    return $this->hasMany(Photo::class);
  }
}
