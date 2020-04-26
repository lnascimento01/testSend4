<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Wishlist extends Repository {

    protected $table = 'user_favs';

    /**
     * @param array $data
     * @return bool
     */
    public function setFavorite($data = []) {
        return DB::table($this->table)
            ->insert([
                "id_user" => $data["idUser"],
                "id_product" => $data["idProduct"]
            ]);
    }

    /**
     * @param $idFav
     * @return int
     */
    public function delFavorite($idFav) {
        return DB::table($this->table)
            ->where(
                "id", "=", $idFav
            )
            ->delete();
    }

    /**
     * @param $idUser
     * @return int
     */
    public function clearFavorites($idUser) {
        return DB::table($this->table)
            ->where(
                "id_user", "=", $idUser
            )
            ->delete();
    }

    /**
     * @param array $data
     * @return array
     */
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

    public function getFavorites($idUser) {
        return DB::table($this->table)
            ->where(
                "id_user", "=", $idUser
            )
            ->get()
            ->toArray();
    }
}