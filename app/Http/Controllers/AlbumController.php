<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;


class AlbumController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Album::all();
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

    $request->validate([
      'title' => 'required',
      'cityId' => 'required'
    ]);

    $album = new Album();
    $album->title = $request->input('titre');
    $album->city_id = $request->input('cityId');

    $data =  $album->save();
    if (!$data) {
      return response()->json([
        'status' => 400,
        'error' => 'something went wrong'
      ]);
    } else {
      return response()->json([
        'status' => 200, $album, 'message ' => 'Data Successfully saved'
      ]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Album::find($id);
  }

  public function findById($id)
  {
    $album = Album::find($id);
    if(is_null($album))
      return null; 
    return [
      'id' => $album->id,
      'title' => $album->title,
      'description' => $album->description,
      'createdAt' => $album->created_at,
      'updatedAt' => $album->updated_at,
      'photos' => $album->photos()->get()
    ];
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

    $Album =  Album::find($id);
    $Album->titre = $request->input('titre');
    $Album->date_album = $request->input('date_album');
    $Album->organisme_id = $request->input('organisme_id');
    $Album->save();


    return response()->json($Album);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return Album::destroy($id);
  }
}
