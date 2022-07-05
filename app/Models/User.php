<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Models\Role;

class User extends \TCG\Voyager\Models\User
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = ['name', 'last_name', 'email', 'password', 'city_id', 'active'];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = ['password', 'remember_token', 'active'];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = ['email_verified_at' => 'datetime'];

  public function notifications()
  {
    return $this->hasMany(Notification::class);
  }

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }

  public function events()
  {
    $eventList = $this->hasMany(Event::class)->get();
    return Event::mapEvents($eventList);
  }

  public function getRole(){
    return $this->belongsTo('TCG\Voyager\Models\Role' , 'role_id' ,'id');
  }

  public function role_name() {
    return Role::find($this->role_id)->name;
  }
}
