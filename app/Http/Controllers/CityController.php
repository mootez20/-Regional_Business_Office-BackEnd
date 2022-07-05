<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Event;
use App\Models\Subject;

class CityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $cityList = City::all();
    $cities = [];
    foreach ($cityList as $city) {
      array_push($cities, City::mapCity($city));
    }
    return $cities;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(City $city)
  {
    return $city;
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function findEvents($id)
  {
    $city = City::find($id);
    return is_null($city) ? Event::events(false) : $city->events(false);
  }

  public function findNews($id)
  {
    $city = City::find($id);
    return is_null($city) ? Event::events(true) : $city->events(true);
  }

  public function topEvents($id)
  {
    $city = City::find($id);
    return is_null($city) ? Event::topEvents(false) : $city->topEvents(false);
  }

  public function topNews($id)
  {
    $city = City::find($id);
    return is_null($city) ? Event::topEvents(true) : $city->topEvents(true);
  }

  public function albums($id)
  {
    $city = City::find($id);
    $albumList = is_null($city) ? Album::all() : $city->albums()->get();
    $albums = [];
    foreach ($albumList as $album) {
      $album = [
        'id' => $album->id,
        'title' => $album->title,
        'description' => $album->description,
        'createdAt' => $album->created_at,
        'updatedAt' => $album->updated_at,
        'photos' => $album->photos()->take(1)->get()
      ];
      array_push($albums, $album);
    }
    return $albums;
  }

  public function topAlbums($id)
  {
    $city = City::find($id);
    $albumList = (is_null($city) ? Album::take(3) : $city->albums()->take(3))->get();
    $albums = [];
    foreach ($albumList as $album) {
      $album = [
        'id' => $album->id,
        'title' => $album->title,
        'description' => $album->description,
        'createdAt' => $album->created_at,
        'updatedAt' => $album->updated_at,
        'photos' => $album->photos()->take(1)->get()
      ];
      array_push($albums, $album);
    }
    return $albums;
  }
}
