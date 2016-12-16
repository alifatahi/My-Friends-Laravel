<?php

namespace friends\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = [
       'body'
    ];

    //nethod to make relation to user tabele
    public function user()
    {
      //becuase each Status belongs To only one user
      return $this->belongsTo('friends\Models\User','user_id');
    }

    //method to declare the Status where not reply yet
      //also its scope method which we can access to queryBuilder
    public function scopeNotReply($query)
    {
        //check where its parent_id is null
       return $query->whereNull('parent_id');
    }
      //method to declare relation becuase each
      // status may have many reply to the one parent_id
    public function replies()
    {
      return $this->hasMany('friends\Models\Status','parent_id');
    }
     //method to make ability to like Status
    public function likes()
    {
      //now becuase we declare that our like is morph so
      //with morphMany we can declare which model and which column to use
      return $this->morphMany('friends\Models\Like','likeable');
    }
}
