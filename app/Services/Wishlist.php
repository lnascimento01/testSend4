<?php

namespace App\Services;

use App\Jobs\MailFavorites;
use App\Repositories\Wishlist as WishlistRepo;

class Wishlist {
    private $user;
    public $whishlistRepo;

    /**
     * Wishlist constructor.
     * @param WishlistRepo $whishlistRepo
     */
    public function __construct(
        WishlistRepo $whishlistRepo
    ) {
        $this->user          = auth()->user();
        $this->whishlistRepo = $whishlistRepo;
    }

    /**
     * @param $idProduct
     * @return bool|int
     */
    public function handleFavorite($idProduct) {
        $validate = $this->validateProdFav($idProduct);

        if ($validate) {
            $return = $this->whishlistRepo->delFavorite(current($validate)->id);
        } else {
            $return = $this->whishlistRepo->setFavorite(
                [
                    "idProduct" => $idProduct,
                    "idUser" => $this->user['id']
                ]
            );
        }

        MailFavorites::dispatch($this->user['email'])->delay(now()->addMinutes(2));

        return $return;
    }

    /**
     * Validate if the wishlist already have the product
     * @param $idProduct
     * @return WishlistRepo
     */
    public function validateProdFav($idProduct) {
        return $this->whishlistRepo->checkFavorite(
            [
                "idProduct" => $idProduct,
                "idUser" => $this->user['id']
            ]
        );
    }

    /**
     * @return array
     */
    public function listFavs() {
        return $this->whishlistRepo->getFavorites($this->user['id']);
    }

    /**
     * @param $payload
     */
    public function sendMail($payload) {
        echo "Email enviado";
    }
}