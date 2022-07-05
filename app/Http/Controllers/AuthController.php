<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $fields = $request->validate([
      'firstName' => ['required', 'string'],
      'lastName' => ['required', 'string'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6'],
    ]);

    User::create([
      'name' => $fields['firstName'],
      'last_name' => $fields['lastName'],
      'email' => $fields['email'],
      'password' => bcrypt($fields['password']),
    ]);

    return response(['message' => 'User successfully created'], 201);
  }

  public function login(Request $request)
  {
    $fields = $request->validate([
      'email' =>  ['required', 'string'],
      'password' =>  ['required', 'string'],
    ]);

    //check email
    $user = User::where('email', $fields['email'])->first();

    //check password
    if (!$user || !Hash::check($fields['password'], $user->password)) {
      return response(['message' => 'wrong username or password'], 401);
    }
    $token = $user->createToken('myapptoken')->plainTextToken;
    $city = is_null($user->city_id) ? null : City::find($user->city_id);

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

    $response = ['user' => $data, 'token' => $token];
    return response($response, 200);
  }


  public function logout(Request $request)
  {
    auth()->user()->token->delete();
    return response(['message' => 'Logged out'], 200);
  }

  public function forgetPassword(Request $request)
  {
    $this->validate($request, ['email' => ['required', 'email']]);
    $email = $request->email;

    if (User::where('email', $email)->doesntExist()) {
      return response(['message' => 'messages.emailNotFound'], 409);
    }

    $token = Str::random(10);
    DB::table('password_resets')->insert([
      'email' => $email,
      'token' => $token,
      'created_at' => now()->addHours(6)
    ]);

    //Send Mail
    Mail::send('mail.resetPassword', ['token' => $token], function ($message) use ($email) {
      $message->to($email);
      $message->subject('Reset Your Password');
    });

    return response(['message' => 'messages.checkEmail'], 200);
  }

  public function resetPassword(Request $request)
  {
    $this->validate($request, [
      'token' => ['required', 'email'],
      'password' => ['required', 'string']
    ]);

    $token = $request->token;
    $passwordReset = DB::table('password_resets')->where('token', $token)->first();
    if (!$passwordReset) {
      return response(['message' => 'messages.tokenNotFound'], 409); // @wissem
    }

    $user = User::where('email', $passwordReset->email)->first();
    if (!$user) {
      return response(['message' => 'messages.userNotFound'], 409); // @wissem
    }
    $user->password = Hash::make($request->password);
    $user->save();

    DB::table('password_resets')->where('token', $token)->delete();
    return response(['message' => 'messages.passwordResetSuccessfully'], 200); // @wissem تم تحديث كلمة المرور بنجاح
  }
}
