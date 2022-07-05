<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
  public const News = 'News';
  public const Event = 'Event';

  public static $types = [self::News, self::Event];

  protected $fillable = ['title', 'type', 'checked', 'user_id', 'event_id', 'created_at'];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function event() {
    return $this->hasOne(User::class);
  }
}
