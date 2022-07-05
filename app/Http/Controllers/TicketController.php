<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Ticket::all();
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
    $ticket = new Ticket();
    $ticket->user_id = $request->input('userId');
    $ticket->event_id = $request->input('eventId');
    $ticket->created_at = $request->input('createdAt');
    $ticket->price = $request->input('price');
    $ticket->quantity = $request->input('quantity');
    $ticket->save();

    return response()->json($ticket);
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
    $ticket = Ticket::find($id);
    $ticket->price = $request->input('price');
    $ticket->quantity = $request->input('quantity');
    $ticket->update();

    return response()->json($ticket);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Ticket::find($id);
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


  public static function findByEventId($event_id)
  {
    $tickets = Ticket::where('user_id', auth()->user()->id)->where('event_id', $event_id)->get();
    if (count($tickets) == 0) {
      return null;
    }
    $ticket = $tickets[0];
    $event = Event::find($ticket->event_id);
    return [
      'id' => $ticket->id,
      'price' => $ticket->price,
      'quantity' => $ticket->quantity,
      'createdAt' => $ticket->created_at,
      'event' => [
        'id' => $event->id,
        'title' => $event->title,
        'startedAt' => $event->started_at,
        'createdAt' => $event->created_at,
        'endedAt' => $event->ended_at,
      ]
    ];
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
