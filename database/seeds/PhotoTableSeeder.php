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
        factory(App\Photo::class,500)->create()->each(function($photo){
            $gallery = App\Gallery::inRandomOrder()->first();
            $photo->gallery_id = $gallery->id;
            $photo->save();
        });
    }
}
