<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Wishlist extends Repository {

    protected $table = 'user_favs';

    public function setFavorite($data = []) {
        return DB::table($this->table)
            ->insert([
                "id_user" => $data["idUser"],
                "id_product" => $data["idProduct"]
            ]);
    }

    public function delFavorite($idFav) {
        return DB::table($this->table)
            ->where(
                "id", "=", $idFav
            )
            ->delete();
    }

    public function clearFavorites($idUser) {
        return DB::table($this->table)
            ->where(
                "id_user", "=", $idUser
            )
            ->delete();
    }

    public function checkFavorite($data = []) {
        return DB::table($this->table)
            ->where(
                [
                    ["id_user", "=", $data['idUser']],
                    ["id_product", "=", $data['idProduct']]
                ]
            )
            ->get("id")->toArray();
    }
}