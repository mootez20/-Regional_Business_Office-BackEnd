<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
  public function show($id)
  {
    //
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

  public static function findTickets($id)
  {
    $ticketList = Ticket::where('user_id', $id)->get();
    $tickets = [];
    foreach ($ticketList as $ticket) {
      $event = Event::find($ticket->event_id);
      $ticket = [
        'id' => $ticket->id,
        'price' => $ticket->price,
        'quantity' => $ticket->quantity,
        'createdAt' => $ticket->created_at,
        'event' => [
          'id' => $event->id,
          'title' => $event->title,
          'image' => $event->image,
          'location' => $event->location,
          'startedAt' => $event->started_at,
          'createdAt' => $event->created_at,
          'endedAt' => $event->ended_at,
        ]
      ];
      array_push($tickets, $ticket);
    }
    return $tickets;
  }

  public function findNotifications($id)
  {
    $notificationList = Notification::where('user_id', $id)->get();
    $notifications = [];
    foreach ($notificationList as $notification) {
      $notification = [
        'id' => $notification->id,
        'title' => $notification->title,
        'description' => $notification->description,
        'type' => $notification->type,
        'checked' => $notification->checked,
        'createdAt' => $notification->created_at,
        'event' => Event::find($notification->event_id),
      ];
      array_push($notifications, $notification);
    }

    return $notifications;
  }

  public function findEvents($id)
  {
    $user = User::find($id);
    return $user ?  $user->events() : [];
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $user = User::find($id);
    $user->name = $request->input('firstName');
    $user->last_name = $request->input('lastName');
    $user->phone = $request->input('phone');
    $user->address = $request->input('address');
    $user->city_id = $request->input('cityId');
    $user->save();

    $city = is_null($user->city_id) ? null : City::where('id', $user->city_id)->first();
    $data = [
      'id' => $user->id,
      'firstName' => $user->name,
      'lastName' => $user->last_name,
      'email' => $user->email,
      'phone' => $user->phone,
      'address' => $user->address,
      'image' => $user->image,
      'isAdmin' => $user->role_name() == "admin" || $user->role_name() == "director" ? 1 : 0,
      'city' => is_null($city) ? null : City::mapCity($city),
    ];
    return $data;
  }

  public function updateImage(Request $request)
  {
    $user = User::find($request['userId']);

    if($request ->hasFile('image')){
      $completeFileName = $request->file('image')->getClientOriginalName();
      $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
      $extension = $request->file('image')->getClientOriginalExtension();
      $comPic = str_replace(' ','_', $fileNameOnly).'-'.rand() . '_'.time(). '.'.$extension;
      $path = $request->file('image')->store('users');
      
      $user->image = $path;
      $user->save();
  }
  if($user->save()){
    $response = [
        'user' => $user,
        'image'=>$path
    ];
    return response($response, 201 );
} else{
    return ['status' =>false, 'image'=>'Somthing went wrong'];
}
  }

  public function editPassword(Request $request)
  {
    $request->validate(['id' => 'required', 'currentPassword' => 'required | string', 'newPassword' => 'required | string',]);

    $user = User::find($request['id']);

    if (Hash::check($request['currentPassword'], $user->password)) {
      $user->update(['password' => Hash::make($request['newPassword'])]);
      return response()->json(['message' => 'messages.passwordUpdatedSuccessfully'], 200);
    } else {
      return response()->json(['message' => 'messages.wrongPassword'], 400);
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
    //
  }
}
