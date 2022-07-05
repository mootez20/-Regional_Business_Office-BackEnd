<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Subscription;
use App\Models\User;

class EventController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $data =  Event::paginate(5);
    // return view('ListEvenement',['events'=> $data ]);

    return Event::all();
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
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Event $event)
  {
    return $event;
  }

  public function eventById($id)
  {
    $event = Event::find($id);
    return [
      'id' => $event->id,
      'title' =>  $event->title,
      'description' => $event->description,
      'nature' => $event->nature,
      'image' => $event->image,
      'location' => $event->location,
      'price' => $event->price,
      'createdAt' => $event->created_at,
      'startedAt' => $event->started_at,
      'endedAt' => $event->ended_at,
      'form' => $event->form,
      'comments' => $event->comments($event->id),
      'commentsCount' => $event->commentsCount($event->id),
    ];
  }

  public function newsById($id)
  {
    $event = Event::find($id);
    return [
      'id' => $event->id,
      'title' =>  $event->title,
      'description' => $event->description,
      'nature' => $event->nature,
      'image' => $event->image,
      'location' => $event->location,
      'price' => $event->price,
      'createdAt' => $event->created_at,
      'comments' => $event->comments($event->id),
      'commentsCount' => $event->commentsCount($event->id),
    ];
  }

  public function getLastFiveNews(){
    return Event::orderBy('created_at','desc')->where('nature','News')->take(5)->get();
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
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'nature' => 'required',
      'image' => 'required',
    ]);

    $event = new Event();
    $event->title = $request['title'];
    $event->nature = $request['nature'];
    $event->started_at = $request['startedAt'];
    $event->ended_at = $request['endedAt'];
    $event->location = $request['location'];
    $event->price = $request['price'];
    $event->user_id = $request['user_id'];
    $event->city_id = $request['city_id'];
    // $event->image = $request['image'];

    $data = Event::create($event);

    $users = User::where('city_id', $event->city_id)->get();
    foreach ($users as $user) {
      $notification = new Notification();
      $notification->title = $event->title;
      $notification->description = $event->description;
      $notification->type = $event->nature === Event::News ? Notification::News : Notification::Event;
      $notification->event_id = $event->id;
      $notification->user_id = $user->id;
      Notification::create($notification);
    }

    // TODO: send mail to subscribers
    $subscribers = Subscription::all();

    if ($data) {
      return response()->json([
        'status' => 200,
        $event,
        'message ' => 'Data Successfully saved'
      ]);
    } else {
      return response()->json([
        'status' => 400,
        'error' => 'something went wrong'
      ]);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Event $event)
  {
    $request->validate([
      'title' => 'required',
      'nature' => 'required',
    ]);

    $event->title = $request['title'];
    $event->started_at = $request['startedAt'];
    $event->ended_at = $request['endedAt'];
    $event->location = $request['location'];
    $event->price = $request['price'];

    $event->save();

    return response()->json($event);
  }

  public function updateImage(Request $request)
  {
    if ($request->hasFile('image')) {
      $event = Event::find($request['eventId']);
      $extension = $request->file('image')->getClientOriginalExtension();
      $fileName = rand().'_'.time().'.'.$extension;
      $imagePath = $request->file('image')->storeAs("public/events", $fileName);
      $event->image = str_replace('public/','', $imagePath);
      $event->save();
      return ['image' => $event->image];
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return Event::destroy($id);
  }
}
