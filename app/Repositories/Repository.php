<?php


namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Repository {

    protected $table = '';

    public function select($sql, array $params = []) {
        return DB::select($sql, $params);
    }

    public function insert($sql, $data) {
        return DB::insert($sql, $data);
    }

    public function update($sql, $data) {
        return DB::update($sql, $data);
    }
}