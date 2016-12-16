<?php

namespace friends\Http\Controllers;

use Auth;
use friends\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
   /*SignUp*/
   //sign up route
   public function getSignUp()
    {
       return view('auth.signup');
    }

    //submit user
    public function postSignUp(Request $request)
     {
       $this->validate($request,[
         'username' => 'required|unique:users|alpha_dash|max:20',
         'email' => 'required|unique:users|email|max:255',
         'password' => 'required|min:6',
       ]);

      User::create([
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
      ]);
      return redirect()
      ->route('home')
      ->with('info','Your account has been created; Please LogIn');
     }

    /*Login*/
    //login route
    public function getLogIn()
    {
      return view('auth.login');
    }
//method for recive user info for login
    public function postLogIn(Request $request)
    {
      $this->validate($request,[
        'email' => 'required|email',
        'password' => 'required|min:6'
      ]);
      //we also using has for remember me functionality
      if (!Auth::attempt($request->only(['email','password']),
                         $request->has('remember'))) {
         return redirect()->back()->with('info','Email Or Password Is Wrong Please Try again');
      }
      return redirect()->route('home')->with('info','You are LogIn');
    }
//method for logout
    public function getlogOut()
    {
       Auth::logout();
       return redirect()->route('home');
    }

}
