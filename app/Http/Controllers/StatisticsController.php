<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Form;
use App\Models\Ticket;

class StatisticsController extends Controller
{

  public function cityStatistics()
  {
    $cityList = City::all();
    $cities = [];
    foreach ($cityList as $city) {
      $eventsCount = $city->_events(false)->count();
      $usersCount = $city->users()->count();
      $ticketsCount = 0;
      $responsesCount = 0;
      $events = $city->_events(false);
      foreach ($events as $event) {
        $ticketsCount += Ticket::where('event_id', $event->id)->count();
        $responsesCount += Form::where('form_id', $event->form_id)->where('nature', Form::Response)->count();
      }
      array_push($cities, [
        'name' => $city->name,
        'eventsCount' => $eventsCount,
        'usersCount' => $usersCount,
        'ticketsCount' => $ticketsCount,
        'responsesCount' => $responsesCount,
      ]);
    }

    return $cities;
  }
}
