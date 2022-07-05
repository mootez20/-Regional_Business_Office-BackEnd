<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Service;

class City extends Model
{
  protected $fillable = ['name', 'description', 'location', 'images'];

  public function _events(bool $isNews)
  {
    return $this->hasMany(Event::class)->where('nature', $isNews ? '=' : '<>', Event::News)->get();
  }

  public function events(bool $isNews)
  {
    $eventList =  $this->_events($isNews);
    return Event::mapEvents($eventList);
  }

  public function topEvents(bool $isNews)
  {
    $eventList =  $this->hasMany(Event::class)->where('nature', $isNews ? '=' : '<>', Event::News)->limit(4)->get();
    return Event::mapEvents($eventList);
  }

  public function albums()
  {
    return $this->hasMany(Album::class);
  }

  public function services()
  {
    return $this->hasMany(Service::class);
  }

  public function subjects()
  {
    return $this->hasMany(Subject::class);
  }

  public function users()
  {
    return $this->hasMany(User::class);
  }

  public function user(){
    return $this->belongsTo(User::class);
  }

  public static function mapCity(City $city)
  {
    return
      [
        'id' => $city->id,
        'name' => $city->name,
        'description' => $city->description,
        'location' => $city->location,
        'createdAt' => $city->created_at,
        'images' => explode(",", $city->images),
      ];
  }
}
