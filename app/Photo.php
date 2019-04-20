<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'url','gallery_id'
    ];

    public function gallery(){
        return $this->belongsTo(Gallery::class);
    }
}
