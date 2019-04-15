<?php

use Illuminate\Database\Seeder;

class PhotoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Photo::class,100)->create()->each(function($photo){
            $gallery = App\Gallery::inRandomOrder()->first();
            $photo->gallery_id = $gallery->id;
            $photo->save();
        });
    }
}
