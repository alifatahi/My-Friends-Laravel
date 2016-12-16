<?php

namespace friends\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table= 'likeable';
     //method to like anything
    public function likeable()
    {
        //this is ploymorphic relations and we
        //can apply to other models
      return $this->morphTo();
    }
       //method to declare our foreign key relation which is user_id
    public function user()
    {
      return $this->belongsTo('friends\Models\User','user_id');
    }


}
