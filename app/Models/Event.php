<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;


class Event extends Model
{
  public const News = 'News';
  public const CulturalEvent = 'CulturalEvent';
  public const SportEvent = 'SportEvent';
  public const ScientificEvent = 'ScientificEvent';
  public const EconomicEvent = 'EconomicEvent';
  public const ArtEvent = 'ArtEvent';

  public static $natures = [self::News, self::CulturalEvent, self::SportEvent, self::ScientificEvent, self::EconomicEvent, self::ArtEvent];

  protected $fillable = ['title', 'nature', 'created_at', 'image', 'city_id', 'user_id'];

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public static function events(bool $isNews)
  {
    $eventList = Event::where('nature', $isNews ? '=' : '<>', Event::News)->get();
    return Event::mapEvents($eventList);
  }

  public static function topEvents(bool $isNews)
  {
    $eventList = Event::where('nature', $isNews ? '=' : '<>', Event::News)->take(4)->get();
    return Event::mapEvents($eventList);
  }

  public function form()
  {
    return $this->hasOne(Form::class);
  }

  public function comments($event_id)
  {
    $commentList = Comment::where('event_id', $event_id)->whereNull('comment_id')->get();
    $comments = [];
    foreach ($commentList as $comment) {
      $subCommentList = Comment::where('comment_id', $comment->id)->get();
      $subComments = [];
      foreach ($subCommentList as $subComment) {
        $_user = User::find($subComment->user_id);
        $subComment = [
          'id' => $subComment->id,
          'content' => $subComment->content,
          'createdAt' => $subComment->created_at,
          'user' => [
            'firstName' => $_user->name,
            'lastName' => $_user->last_name,
            'image' => $_user->image,
          ]
        ];
        array_push($subComments, $subComment);
      }
      $user = User::find($comment->user_id);
      $comment = [
        'id' => $comment->id,
        'content' => $comment->content,
        'createdAt' => $comment->created_at,
        'user' => [
          'firstName' => $user->name,
          'lastName' => $user->last_name,
          'image' => $user->image,
        ],
        'subComments' => $subComments
      ];
      array_push($comments, $comment);
    }
    return $comments;
  }

  public function commentsCount($event_id)
  {
    Comment::where('event_id', $event_id)->count();
  }

  public static function mapEvents($eventList)
  {
    $events = [];
    foreach ($eventList as $event) {
      $event = [
        'id' => $event->id,
        'title' => $event->title,
        'description' => $event->description,
        'nature' => $event->nature,
        'image' => $event->image,
        'location' => $event->location,
        'hasForm' => $event->form ? true : false,
        'form' => $event->form,
        'price' => $event->price,
        'createdAt' => $event->created_at,
        'startedAt' => $event->started_at,
      ];
      array_push($events, $event);
    }

    return $events;
  }
}
