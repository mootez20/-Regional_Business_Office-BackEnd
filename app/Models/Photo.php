<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Photo extends Model
{
  protected $fillable = ['name', 'url', 'created_at', 'album_id', 'city_id'];
}
