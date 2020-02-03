<?php

use Illuminate\Database\Seeder;

class RoomSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \Illuminate\Support\Facades\DB::table("rooms")->insert([
            [
                "roomID" => "601",
                "roomFloor"=>6
            ],
            [
                "roomID" => "602",
                "roomFloor"=>6
            ],
            [
                "roomID" => "603",
                "roomFloor"=>6
            ],
            [
                "roomID" => "604",
                "roomFloor"=>6
            ],
            [
                "roomID" => "605",
                "roomFloor"=>6
            ],
            [
                "roomID" => "606",
                "roomFloor"=>6
            ],
            [
                "roomID" => "607",
                "roomFloor"=>6
            ],
            [
                "roomID" => "608",
                "roomFloor"=>6
            ],
            [
                "roomID" => "609",
                "roomFloor"=>6
            ],
            [
                "roomID" => "610",
                "roomFloor"=>6
            ],
            [
                "roomID" => "613",
                "roomFloor"=>6
            ],
            [
                "roomID" => "614",
                "roomFloor"=>6
            ],
            [
                "roomID" => "621",
                "roomFloor"=>6
            ],
            [
                "roomID" => "622",
                "roomFloor"=>6
            ],
            [
                "roomID" => "623",
                "roomFloor"=>6
            ],
            [
                "roomID" => "624",
                "roomFloor"=>6
            ],
            [
                "roomID" => "625",
                "roomFloor"=>6
            ],
            [
                "roomID" => "626",
                "roomFloor"=>6
            ],
            [
                "roomID" => "627",
                "roomFloor"=>6
            ],
            [
                "roomID" => "628",
                "roomFloor"=>6
            ],
            [
                "roomID" => "629",
                "roomFloor"=>6
            ],
            [
                "roomID" => "630",
                "roomFloor"=>6
            ],
            [
                "roomID" => "631",
                "roomFloor"=>6
            ],
            [
                "roomID" => "706",
                "roomFloor"=>7
            ],
            [
                "roomID" => "708",
                "roomFloor"=>7
            ],
            [
                "roomID" => "710",
                "roomFloor"=>7
            ],
            [
                "roomID" => "711A",
                "roomFloor"=>7
            ],
            [
                "roomID" => "721",
                "roomFloor"=>7
            ],
            [
                "roomID" => "723",
                "roomFloor"=>7
            ],
            [
                "roomID" => "725",
                "roomFloor"=>7
            ],
            [
                "roomID" => "727",
                "roomFloor"=>7
            ],
            [
                "roomID" => "729",
                "roomFloor"=>7
            ]
        ]);
    }
}
