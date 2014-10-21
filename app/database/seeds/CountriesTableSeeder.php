<?php

class CountriesTableSeeder extends Seeder {

    public function run()
    {
        $countries = [
            [
                'id'   => '1',
                'name' => 'database',
                'slug' => 'database',
            ],
            [
                'id'   => '2',
                'name' => 'view data',
                'slug' => 'view-data',
            ],
            [
                'id'   => '3',
                'name' => '4.1',
                'slug' => '41',
            ],
        ];

        DB::table('tags')->insert($countries);

        DB::table('tag_trick')->insert([
            [ 'country_id' => '1', 'trick_id' => '1' ],
            [ 'country_id' => '2', 'trick_id' => '2' ],
            [ 'country_id' => '1', 'trick_id' => '3' ],
            [ 'country_id' => '3', 'trick_id' => '3' ],
        ]);
    }
}
