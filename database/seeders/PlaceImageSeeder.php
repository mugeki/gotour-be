<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('place_images')->count() == 0) {
            DB::table('place_images')->insert([
                [ // Raja ampat
                    'img_url' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                    'place_id' => 1,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                    'place_id' => 1,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1637060544104-ce8f8b6b4d81?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                    'place_id' => 1,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1621167832294-97b94e5dbb37?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80',
                    'place_id' => 1,
                ],
                [ // Borobudur
                    'img_url' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                    'place_id' => 2,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1631340729644-8b8aad1e9dba?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                    'place_id' => 2,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1589310287002-b26eddda5e6a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80',
                    'place_id' => 2,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1612127342760-222e72aca87b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80',
                    'place_id' => 2,
                ],
                [ // Tangkuban perahu
                    'img_url' => 'https://images.unsplash.com/photo-1622866350324-d582d9487d1f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80',
                    'place_id' => 3,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1631005441185-0cdb5fe1b126?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1032&q=80',
                    'place_id' => 3,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1631556211397-2b24600fb878?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                    'place_id' => 3,
                ],
                [
                    'img_url' => 'https://images.unsplash.com/photo-1558545233-4151f74b7c48?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
                    'place_id' => 3,
                ],
            ]);
        }

    }
}