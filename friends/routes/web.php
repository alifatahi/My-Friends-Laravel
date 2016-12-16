<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//Home
Route::get('/',[
  'uses' => 'HomeController@index',
  'as'  =>  'home'
]);

/*Authentication*/
 //signup get route
Route::group(['middleware'=>'guest'],function(){
Route::get('/signup',[
  'uses' => 'AuthController@getSignUp',
  'as'   => 'auth.signup'
  ]);

//signup post
Route::post('/signup',[
  'uses' => 'AuthController@postSignUp',
]);

//login
Route::get('/login',[
   'uses' => 'AuthController@getLogIn',
   'as'   => 'auth.login',
]);
//post login
Route::post('/login',[
  'uses' => 'AuthController@postLogIn'
  ]);

});
//logout
Route::get('/logout',[
   'uses' => 'AuthController@getLogOut',
   'as'   => 'auth.logout',
]);

/*Search*/

//search route
Route::get('/serach',[
    'uses' => 'SearchController@getResults',
    'as'   => 'search.results'
]);


/*User Profile*/

//user profile route
Route::get('/user/{username}',[
  'uses' => 'ProfileController@getProfile',
  'as'   => 'profile.index'
]);
//make auth group route
Route::group(['middleware'=>'auth'],function(){
  //edit profile route
Route::get('/profile/edit',[
  'uses' => 'ProfileController@getEdit',
  'as'   => 'profile.edit'
]);
  //edit profile route for post
Route::post('/profile/edit',[
  'uses' => 'ProfileController@postEdit',
]);

/*Friends*/
  //friends Index Route
  Route::get('/friends',[
       'uses' => 'FriendController@getIndex',
       'as'   => 'friends.index'
  ]);
  //add friends route
  Route::get('/friends/add/{username}',[
    'uses' => 'FriendController@getAdd',
    'as'   =>  'friends.add'
  ]);
   //accept friend route
  Route::get('/friends/accept/{username}',[
    'uses' => 'FriendController@getAccept',
    'as'   =>  'friends.accept'
  ]);
    //remove friend route
  Route::post('/friends/remove/{username}',[
    'uses' => 'FriendController@postRemove',
    'as'   =>  'friends.remove'
  ]);

  /*Status Route*/
  //route to post status
    Route::post('/status',[
       'uses' => 'StatusController@postStatus',
        'as'  => 'status.post'
    ]);
    //route to reply to post status
      Route::post('/status/{statusId}/reply',[
         'uses' => 'StatusController@postReply',
          'as'  => 'status.reply'
      ]);
     //route for like Status
      Route::get('/status/{statusId}/like',[
        'uses' => 'StatusController@getLike',
        'as'   => 'status.like'
      ]);
});
