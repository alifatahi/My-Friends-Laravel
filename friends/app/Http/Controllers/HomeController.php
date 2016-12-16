<?php

namespace friends\Http\Controllers;

use Auth;
use friends\Models\Status;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //main route in our website
    public function index()
    {
      //if user login we show this page
      if (Auth::check()) {
        //with status where they are reply or not reply
         $statuses = Status::notReply()->where(function($query){
           //where its belongs to current user id
           return $query->where('user_id',Auth::user()->id)
           //or belongs to cuurenet user friends by using pluck to lists they id
        ->orWhereIn('user_id',Auth::user()->friends()->pluck('id'));
         })
         //order by time
         ->orderBy('created_at','desc')
         //paginate them limit by 10
         ->paginate(10);
        return view('timeline.index')
               ->with('statuses',$statuses);
      }
      //otherwise this page
      return view('home');
    }
}
