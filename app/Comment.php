<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // protected $fillable = [
    //     'text', 'gallery_id','user_id'
    // ];

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function gallery(){
        return $this->belongsTo(Gallery::class,'gallery_id');
    }
}
