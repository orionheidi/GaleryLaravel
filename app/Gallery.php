<?php

namespace App;
use App\Photo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{
    
    protected $fillable = [
        'name', 'description','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


}
