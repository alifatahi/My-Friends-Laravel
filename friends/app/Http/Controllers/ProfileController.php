<?php

namespace friends\Http\Controllers;

use Auth;
use friends\Models\User;
use Illuminate\Http\Request;

/*Class for User Profile*/
class profileController extends Controller
{
     //get user profile
     public function getProfile($username)
     {
       //find user
       $user = User::where('username',$username)->first();
       if (!$user) {
         //throw Http execption with abort()
          abort(404);
       }
          //for see latest status from user on profile
       $statuses = $user->statuses()->notReply()->get();
       return view('profile.index')
              ->with('user',$user)
              ->with('statuses',$statuses)
              //here we check to see if user is friend with current user or not
              ->with('authUserIsFriend', Auth::user()->isFriendWith($user));
     }
     //method for get to edit profile
     public function getEdit()
     {
       return view('profile.edit');
     }

     //method for post update
     public function postEdit(Request $request)
     {
       $this->validate($request,[
         'first_name' => 'alpha|max:30',
         'last_name'  => 'alpha|max:30',
         'location'   => 'max:30',
       ]);
          Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location'),
          ]);
          return redirect()->route('profile.edit')
                           ->with('info','Your Profile Update Successfully');
     }
}
