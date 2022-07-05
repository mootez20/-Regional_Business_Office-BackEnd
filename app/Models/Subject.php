<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{
  protected $fillable = ['title', 'city_id'];


  public function comments($subject_id)
  {
    $commentList = Comment::where('subject_id', $subject_id)->whereNull('comment_id')->get();
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
          ],
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
}
