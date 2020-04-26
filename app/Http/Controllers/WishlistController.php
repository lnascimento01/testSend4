<?php

namespace App\Http\Controllers;

use App\Services\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller {

    /**
     * @param Request $request
     * @param Wishlist $products
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function handleFav(Request $request, Wishlist $wishlist) {
        try {
            $idProduct = $request->input("id_product");

            $validate = Validator::make(
                $request->all(),
                [
                    'id_product' => 'required|integer',
                ],
                [
                    'required' => 'Campo ":attribute" é obrigatório!',
                    'integer' => 'O valor informado em ":attribute" deve ser um inteiro!'
                ]
            );

            if ($validate->fails()) {
                return response()->json(
                    ['messages' => $validate->errors()->all()],
                    400
                );
            }
        } catch (\Throwable $e) {
            return report($e);
        }

        return response()->json($wishlist->handleFavorite($idProduct));
    }

    /**
     * @param Wishlist $wishlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFavs(Wishlist $wishlist) {
        return response()->json($wishlist->listFavs());
    }
}
