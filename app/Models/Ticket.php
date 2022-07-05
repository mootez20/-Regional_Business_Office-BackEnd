<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{
  protected $fillable = ['price', 'quantity', 'event_id', 'city_id', 'created_at'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function event()
  {
    return $this->hasOne(Event::class);
  }
}
