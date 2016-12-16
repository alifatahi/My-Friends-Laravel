<?php

namespace friends\Http\Controllers;

use friends\Models\User;
use friends\Models\Status;
use Illuminate\Http\Request;
use Auth;


class StatusController extends Controller
{
  //method to post Status
   public function postStatus(Request $request)
   {
      //validation
      $this->validate($request,[
        'status' => 'required|max:200',
      ]);
        //createe our status
        Auth::user()->statuses()->create([
           'body' => $request->input('status'),
        ]);

        return redirect()->route('home')
                         ->with('info','Status Post');
    }
      //method to reply to Status we need StatusID
    public function postReply(Request $request,$statusId)
    {
       $this->validate($request,[
         "reply-{$statusId}" => 'required|max:200',
       ],[
         //also make its own error message
         "required" => "The Reply Body Is Required"
       ]);
         //now we find Status where they not reply
       $status = Status::notReply()->find($statusId);
        //first we check that status is exist or not
       if (!$status) {
         return redirect()->route('home');
       }
         //sec we check if current user is friends with that user
         if (!Auth::user()->isFriendWith($status->user) &&
           //and also we check this to make this possible
           // to current user answer to his own status becuase
           //his not friends with his slef
             Auth::user()->id !== $status->user->id) {
           return redirect()->route('home');
         }
          //create Status
         $reply = Status::create([
           'body' => $request->input("reply-{$statusId}")
           //also we declare that this message is belongsTo this relation
           //with associate mehtod
         ])->user()->associate(Auth::user());
           //using replies method to save
         $status->replies()->save($reply);

         return redirect()->route('home')
                ->with('info','Your Reply Sent');
    }
     //method to save like
    public function getLike($statusId)
    {
        //first find it
        $status = Status::find($statusId);
          //if Status not exist
         if (!$status) {
           return redirect()->back();
         }
          //if current user not friends with user that send Status
         if (!Auth::user()->isFriendWith($status->user)) {
             return redirect()->back()
                    ->with('info','You are Not Friends So You Cant Like');
         }
         //if user already like Status
         if (Auth::user()->hasLikedStatus($status)) {
            return redirect()->back()
                    ->with('info','You already Liked This');
         }
          //create like
         $like = $status->likes()->create([]);
          //save like
         Auth::user()->likes()->save($like);
         return redirect()->back();
    }
}
