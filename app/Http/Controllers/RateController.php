<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;


class RateController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Rate::all();
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
      'rate' => 'required',
      'userId' => 'required',
      'eventId' => 'required'
    ]);

    $rate = new Rate();
    $rate->rate = $request->input('rate');
    $rate->user_id = $request->input('userId');
    $rate->event_id = $request->input('eventId');

    $data =  $rate->save();
    if (!$data) {
      return response()->json([
        'status' => 400,
        'error' => 'something went wrong'
      ]);
    } else {
      return response()->json([
        'status' => 200,
        $rate,
        'message ' => 'Rate successfully created'
      ]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Rate $rate)
  {
    return $rate;
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
    $rate =  Rate::find($id);
    $rate->rate = $request->input('rate');
    $rate->user_id = $request->input('userId');
    $rate->event_id = $request->input('eventId');
    $rate->save();
    return response()->json($rate);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return Rate::destroy($id);
  }
}
