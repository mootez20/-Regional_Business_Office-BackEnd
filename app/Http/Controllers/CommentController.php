<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Comment::all();
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
      'content' => 'required',
      'userId' => 'required',
    ]);
    $comment = new Comment();
    $comment->content = $request->input('content');
    $comment->user_id = $request->input('userId');
    $comment->event_id = $request->input('eventId');
    $comment->subject_id = $request->input('subjectId');
    $comment->comment_id = $request->input('commentId');

    $success =  $comment->save();
    if ($success) {
      return response()->json(['status' => 201, $comment, 'message' => 'Comment successfully created']);
    } else {
      return response()->json(['status' => 400, 'error' => 'Something went wrong']);
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
    return Comment::find($id);
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
    $comment = Comment::find($id);
    $comment->content = $request->input('content');
    $comment->user_id = $request->input('userId');
    $comment->event_id = $request->input('eventId');
    $comment->subject_id = $request->input('subjectId');
    $comment->comment_id = $request->input('commentId');

    $comment->save();
    return response()->json($comment);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return Comment::destroy($id);
  }
}
