<?php

namespace App\Services;

use App\Jobs\MailFavorites;
use App\Repositories\Wishlist as WishlistRepo;

class Wishlist {
    private $user;
    public $whishlistRepo;
    public $endpoint_prodcut =
        "https://269a1ec67dfdd434dfc8622a0ed77768:4e788173c35d04421ab4793044be622f@send4-avaliacao.myshopify.com/admin/api/2020-04/products.json";

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
        try {

            $favorites       = $this->whishlistRepo->getFavorites($this->user['id']);
            $arraProductsIds = array_column($favorites, "id_product");
        } catch (\Throwable $e) {
            report($e);
        }
        return $this->getProductDetail(implode(",", $arraProductsIds));
    }

    /**
     * @param $strProducts
     * @return mixed
     */
    public function getProductDetail($strProducts) {
        $endpointSetup = curl_init($this->endpoint_prodcut . "?ids=" . $strProducts);

        curl_setopt($endpointSetup, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($endpointSetup);

        return json_decode($response);
    }

    /**
     * @param $payload
     */
    public function sendMail($payload) {
        echo "Email enviado";
    }
}