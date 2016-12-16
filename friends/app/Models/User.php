<?php

namespace friends\Models;

use friends\Models\Status;
use friends\Models\Like;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'age',
        'location',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

//method for get Full name of user to show in website
    public function getName()
    {
      //if we had both first and lastname we show it
      if ($this->first_name && $this->last_name) {
        return "{$this->first_name} {$this->last_name}";
      }
      //if we have only first name we show it
      if ($this->first_name) {
        return "{$this->first_name}";
      }
      return NULL;
    }

//method to show if our getName method not work we show username
    public function getNameOrUsername()
    {
      return $this->getName() ?: $this->username;
    }
   //if only first name and username exist echo them
    public function getFirstNameOrUsername()
    {
      return $this->first_name ?: $this->username;
    }

    //method for get Avatar
    public function getAvatarUrl()
    {
       //using Gravatar with hash UserEmail and also using: MysteriousMan Icon and size of 40
       return "https://www.gravatar.com/avatar/{{ md5($this->email) }}
       ?d=mm&s=40";
    }
     //method to make relation to status table
    public function statuses()
    {
      //because each user may have many Status
      return $this->hasMany('friends\Models\Status','user_id');
    }

    /*2 method for relationship between User and Friends*/

    //first is for see Current user Friends
    public function friendsOfMine()
    {
      /*so first we declare the Model / sec: Our Table To Relation /and 2 last
      is our Foriegn Key*/
      return $this->belongsToMany('friends\Models\User','friends',
                                  'user_id','friend_id');
    }
     //second method is for see Which users are friend with current user
    public function friendOf()
    {
      //here it diffrent we say select from where user is friend id and friends are userid
      return $this->belongsToMany('friends\Models\User','friends',
                                  'friend_id','user_id');
    }

    //method for checking friendship if both user accepted
    public function friends()
    {
      /*first we filter our result from friendsOfMine with wherePivot*/
      //so we say get the useres where current users accept they request
      return $this->friendsOfMine()->wherePivot('accepted',true)->get()
      /*sec we merge(mix) it with friendOf and again we get the result*/
      //and here we say get users who accept current user request
      ->merge($this->friendOf()->wherePivot('accepted',true)->get());
    }

    //method to show friend request
    public function friendRequests()
    {
      //we get result when its false so its waiting for other user accept current user request
      return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

      //method for see friends request pending
    public function friendRequestsPending()
    {
      //here its same as friendRequests method but its for current user accept other user request
      return $this->friendOf()->wherePivot('accepted',false)->get();
    }
     //method for checking if user has any request or not
     //we also need to use our user to see if current user has request
    public function hasFriendRequestsPending(User $user)
    {
        //we also use (bool) to see true or false
       return (bool) $this->friendRequestsPending()->where('id',$user->id)
                           ->count();
    }

    //method to see the other user recevied request from current user
    public function hasFriendRequestsReceived(User $user)
    {
      //same as previous method but this time we use friendRequests
       return (bool) $this->friendRequests()->where('id', $user->id)
                    ->count();
    }
      //method to add friend
    public function addFriend(User $user)
    {
      //we use friendOf method to attach the current user id to that user
      $this->friendOf()->attach($user->id);
    }
      //method tp remove friend
    public function removeFriend(User $user)
    {
       // using detach function to remove 
      $this->friendOf()->detach($user->id);
      $this->friendsOfMine()->detach($user->id);
    }

    //method to accept friends
    public function acceptFriendRequest(User $user)
    {
      //here we use friendRequests method to accept request
       $this->friendRequests()->where('id',$user->id)->first()
       //and then we update our accepted row to true
             ->pivot->update([
               'accepted' => true
             ]);
    }
     //method to see the user friendship
    public function isFriendWith(User $user)
    {
      return (bool) $this->friends()->where('id',$user->id)->count();
    }
     //method to check likes status by user so dont like again
       //we also use Status class as instance for access to they method
    public function hasLikedStatus(Status $status)
    {
      return (bool) $status->likes
             ->where('user_id',$this->id)->count();
    }

    public function likes()
    {
      return $this->hasMany('friends\Models\Like','user_id');
    }


}
