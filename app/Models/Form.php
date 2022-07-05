<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Form extends Model
{
  public const Form = 'Form';
  public const Response = 'Response';

  public static $natures = [self::Form, self::Response];

  protected $fillable = ['name', 'nature', 'event_id', 'created_at'];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }

  public function questions()
  {
    return $this->hasMany(Question::class);
  }
}
