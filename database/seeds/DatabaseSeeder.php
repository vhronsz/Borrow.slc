<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        \Illuminate\Support\Facades\DB::table("header_room_transactions")->insert([
            "roomTransactionID"=>"83204bba-dbe2-351b-a0c2-c5b50b0c9fc3",
            "adminID" => \Faker\Provider\Uuid::uuid(),
            "transactionDate" => '2020-01-01 10:10:10',
            "transactionStatus" => "Registered",
            "updated_at" => \Carbon\Carbon::now(),
        ]);
        \Illuminate\Support\Facades\DB::table("detail_room_transactions")->insert([
            "roomTransactionID" => "83204bba-dbe2-351b-a0c2-c5b50b0c9fc3",
            "roomID"=>601,
            "shiftStart"=>1,
            "shiftEnd"=>2,
            "reason"=>null,
            "internetRequest"=>false,
            "userID1"=>null,
            "userID2"=>null,
        ]);
    }
}
