<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return MenuItem::all();
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
    $MenuItems = new MenuItem();

    $request->validate([
      'nom' => 'required',
      'contenu' => 'required',
      'order' => 'required',
      'menu_id' => 'required'
    ]);

    $MenuItems->nom = $request->input('nom');
    $MenuItems->contenu = $request->input('contenu');
    $MenuItems->order = $request->input('order');
    $MenuItems->menu_id = $request->input('menu_id');

    $data =  $MenuItems->save();
    if (!$data) {
      return response()->json([
        'status' => 400,
        'error' => 'something went wrong'
      ]);
    } else {
      return response()->json([
        'status' => 200,
        $MenuItems,
        'message ' => 'Data Successfully saved'


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
    return MenuItem::find($id);
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
}
