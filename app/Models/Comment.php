<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
  protected $fillable = ['content', 'user_id'];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }

  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }

  public function subComments()
  {
    return $this->hasMany(Comment::class);
  }
}
