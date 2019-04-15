<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        factory(App\Comment::class,100)->create()->each(function($comment){
            $gallery = App\Gallery::inRandomOrder()->first();
            $user = App\User::inRandomOrder()->first();
            $comment->gallery_id = $gallery->id;
            $comment->user_id = $user->id;
            $comment->save();
        });
    }
}
