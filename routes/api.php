<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('forget-password', 'AuthController@forgetPassword');
Route::post('reset-password', 'AuthController@resetPassword');

Route::resource('cities', CityController::class);
Route::resource('events', EventController::class);
Route::resource('albums', AlbumController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('photos', PhotoController::class);
Route::resource('rates', RateController::class);
Route::resource('comments', CommentController::class);
Route::resource('partners', PartnerController::class);
Route::resource('documents', DocumentController::class);
Route::resource('sectors', SectorController::class);
Route::resource('services', ServiceController::class);
Route::resource('subscriptions', SubscriptionController::class);
Route::resource('contacts', ContactController::class);

Route::get('events/{id}/details', 'EventController@eventById');
Route::get('news/{id}', 'EventController@newsById');
Route::get('albums/{id}/details', 'AlbumController@findById');
Route::get('subjects/{id}/details', 'SubjectController@findById');
Route::get('cities/{id}/top-news', 'CityController@topNews');
Route::get('cities/{id}/top-events', 'CityController@topEvents');
Route::get('cities/{id}/top-albums', 'CityController@topAlbums');
Route::get('cities/{id}/news', 'CityController@findNews');
Route::get('cities/{id}/events', 'CityController@findEvents');
Route::get('cities/{id}/albums', 'CityController@albums');
Route::get('cities/{id}/services', 'CityController@services');
Route::get('statistics', 'StatisticsController@cityStatistics');

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::resource('tickets', TicketController::class);
  Route::resource('users', UserController::class);
  Route::resource('forms', FormController::class);
  Route::get('users/{id}/tickets', 'UserController@findTickets');
  Route::get('users/{id}/events', 'UserController@findEvents');
  Route::get('users/{id}/notifications', 'UserController@findNotifications');
  Route::post('users/edit-password', 'UserController@editPassword');
  Route::get('tickets/{eventId}/details', 'TicketController@findByEventId');
  Route::put('notifications/{id}/check', 'NotificationController@check');
  Route::post('users/image', 'UserController@updateImage');
  Route::post('events/edit', 'EventController@update');
  Route::post('events/image', 'EventController@updateImage');
  Route::get('forms/{id}/details', 'FormController@findById');
  Route::post('forms/save', 'FormController@save');
  Route::post('responses/{id}', 'FormController@createResponse');
  Route::put('responses', 'FormController@saveResponse');
  // Route::get('events/last5News', 'EventController@getLastFiveNews');
  Route::get('lastFiveNews', 'EventController@getLastFiveNews');

  /* check those */
  Route::resource('tentative', TentativeController::class);
  Route::resource('User_Role', UserRoleController::class);
  Route::resource('menuItem', MenuItemController::class);
  Route::resource('messagerie', MessagerieController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
