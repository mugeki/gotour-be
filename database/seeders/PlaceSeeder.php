<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('places')->count() == 0) {
            DB::table('places')->insert([
                [
                    'id' => 1,
                    'name' => 'Raja Ampat',
                    'location' => 'West Papua',
                    'description' => 'Far from the view-blocking skyscrapers, dense and hectic concrete jungles, congested traffics, flickering electric billboards, endless annoying noises, and all the nuisances of modern cities, you will find a pristine paradise where Mother Nature and warm friendly people welcome you with all the exceptional wonders in Raja Ampat, the islands-regency in West Papua Province. With all the spectacular wonders above and beyond its waters, as well as on land and amidst the thick jungles, this is truly the place where words such as beautiful, enchanting, magnificent, and fascinating get its true physical meaning.',
                    'rating' => 0,
                    'author_id' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => 'Borobudur',
                    'location' => 'Kabupaten Magelang, Central Java',
                    'description' => 'The Sailendra dynasty built this Largest Buddhist monument in the world between AD 780 and 840. The Sailendra are the ruling dynasty in Central Java at the time. It was built as a place for glorifying Buddha and a pilgrimage spot to guide mankind from worldly desires into enlightenment and wisdom according to Buddha. This monument was discovered by the British in 1814 under Sir Thomas Stanford Raffles, it was until 1835 that the entire area of the temple has been cleared.',
                    'rating' => 0,
                    'author_id' => 2,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'name' => 'Tangkuban Perahu',
                    'location' => 'Bandung, West Java',
                    'description' => 'Tangkuban perahu is an active volcano, situated 30 km north of the city of Bandung in the direction of Lembang. It is the only crater in Indonesia that you can drive up to its very rim. Mount Tangkuban Perahu has a distinctive shape, and looks like an “overturned boat”. Here you will be greeted by sulfur fumes which the crater continues to emit although the volcano is not active.',
                    'rating' => 0,
                    'author_id' => 2,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]);
        }

    }
}