<?php

namespace friends\Http\Controllers;

use Auth;
use friends\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
     //method to go to index of friends with friends and requests
    public function getIndex()
    {
        //listsing our friends
       $friends = Auth::user()->friends();
       //listsing our friend Requests
       $requests = Auth::user()->friendRequests();
       return view('friends.index')
                  ->with('friends',$friends)
                  ->with('requests',$requests);
    }
     //method to add friend
    public function getAdd($username)
    {
        //first we find user
       $user = User::where('username',$username)->first();
       //if that user not exits we redirect
       if (!$user) {
          return redirect()
                 ->route('home')
                ->with('info','this user is not exists');

       }
         //if user try to add his self by get to our add/username
       if (Auth::user()->id === $user->id) {
          return redirect()->back()
          ->with('info','Do You really Want to add Yourself? :)');
       }
       //if current user Or other users has already Friend Requests Pending
       if (Auth::user()->hasFriendRequestsPending($user) ||
           $user->hasFriendRequestsPending(Auth::user())) {
             return redirect()->route('profile.index',['username'=>$user->username])
             ->with('info','Friend Request already Pending');
       }

       //if current user is friends with that user
       if (Auth::user()->isFriendWith($user)) {
           return redirect()->route('profile.index',['usernmae'=>$user->username])
                              ->with('info','You are already Friends with this user. ');
       }
        //adding friend
       Auth::user()->addFriend($user);
       return redirect()->route('profile.index',['username'=>$user->username])
                        ->with('info','Friend request sent');
    }
    //method to accept friend request
    public function getAccept($username)
    {
       $user = User::where('username',$username)->first();

       if (!$user) {
          return redirect()
                 ->route('home')
                ->with('info','this user is not exists');

       }
       //if other user not recived current user request
       if (!Auth::user()->hasFriendRequestsReceived($user)) {
         return redirect()->route('home');
       }
       //if other user accept current user request
       Auth::user()->acceptFriendRequest($user);

       return redirect()->route('profile.index',
                          ['username'=>$user->username])
                        ->with('info','Friend Request accepted') ;
    }
     //method to post remove
    public function postRemove($username)
    {
       //find user
       $user = User::where('username',$username)->first();

       //if Not current user is friends with that user
       if (!Auth::user()->isFriendWith($user)) {
        return redirect()->back();
       }
       //remove it
       Auth::user()->removeFriend($user);

       return redirect()->back()
              ->with('info','Friend Removed');
    }
}
