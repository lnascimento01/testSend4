<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder {
    protected $table = "user";

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table($this->table)->insert([
            [
                "email" => "test1@email.com",
                "password" => "123456",
                "name" => "User Teste 1"
            ],
            [
                "email" => "test2@email.com",
                "password" => "123456",
                "name" => "User Teste 2"
            ],
            [
                "email" => "test3@email.com",
                "password" => "123456",
                "name" => "User Teste 3"
            ],
        ]);
    }
}
