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

    private static function search($term)
    {
        return self::with('user', 'photos')->whereHas('user', function ($query) use ($term) {
            $query
                ->where(
                    DB::raw("CONCAT(first_name, ' ', last_name)"),
                    'LIKE',
                    '%' . $term . '%'
                );
        })
        ->orWhere('name', 'LIKE', '%' . $term . '%')
        ->orWhere('description', 'LIKE', '%' . $term . '%');
    }
    private static function searchUserGalleries($term, $userId)
    {
        return self::with('user', 'photos')
            ->where('user_id', $userId)
            ->where(function ($query) use ($term) {
                $query
                ->where('name', 'LIKE', '%' . $term . '%')
                ->orWhere('description', 'LIKE', '%' . $term . '%');
            });
    }
    public static function getGalleries($request)
    {
        if ($request->query('name')) {
            return Gallery::search($request->query('name'));
        }
        return Gallery::with('photos', 'user');
    }

}
