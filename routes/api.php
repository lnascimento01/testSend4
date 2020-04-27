<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @api {POST} /api/register
 * @apiDescription Endpoint para registro de novos usuários
 * @apiGroup  Authetication
 * @apiName   register
 * @apiParam {String} Name Nome para identificação do usuário.
 * @apiParam {String} email Email para registro como identificação de usuário.
 * @apiParam {String} password Senha de segurança para autenticação.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP / 200 OK
 *     [
 *        {
 *          "access_token": String,
 *          "token_type": String,
 *          "expires_in": Int
 *        },
 *        ...
 *     ]
 *
 *
 */
Route::post('register', 'AuthenticationController@register');

/**
 * @api {POST} /api/login
 * @apiDescription Endpoint para login de usuário
 * @apiGroup  Authetication
 * @apiName   login
 * @apiParam {String} email Email para registro como identificação de usuário.
 * @apiParam {String} password Senha de segurança para autenticação.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP / 200 OK
 *     [
 *        {
 *          "access_token": String,
 *          "token_type": String,
 *          "expires_in": Int
 *        },
 *        ...
 *     ]
 *
 *
 */
Route::post('login', 'AuthenticationController@login');

/**
 * @api {GET} /api/logout
 * @apiDescription Endpoint para logout de usuário
 * @apiGroup  Authetication
 * @apiName   logout
 *
 * @apiSuccessExample Success-Response:
 *     HTTP / 200 OK
 *     [
 *        {
 *          "message": "Successfully logged out"
 *        },
 *        ...
 *     ]
 *
 *
 */
Route::get('logout', 'AuthenticationController@logout');

/**
 * @api {GET} /api/user
 * @apiDescription Endpoint para retorno dos dados de usuário logado
 * @apiGroup  Authetication
 * @apiName   user
 *
 * @apiSuccessExample Success-Response:
 *     HTTP / 200 OK
 *     [
 *        {
 *          "id": Int,
 *          "name": String,
 *          "email": String,
 *          "email_verified_at": UTC,
 *          "created_at": UTC,
 *          "updated_at": UTC
 *      },
 *     ]
 *
 *
 */
Route::get('user', 'AuthenticationController@getAuthUser');

/**
 * Endpoints com permissão somente para usuários logados
 */
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('/')->group(function () {

        /**
         * @api {GET} /api/wishlist
         * @apiDescription Endpoint para retorno dos produtos na lista de favoritos do usuário
         * @apiGroup  management
         * @apiName   wishlist
         *
         * @apiSuccessExample Success-Response:
         *     HTTP / 200 OK
         *     [
         *        {
         *          id: Number,
         *          title: String,
         *          body_html: String,
         *          vendor: String,
         *          product_type: String,
         *          created_at: UTC,
         *          handle: String,
         *          updated_at: UTC,
         *          published_at: UTC,
         *          template_suffix: String,
         *          published_scope: String,
         *          tags: String,
         *          admin_graphql_api_id: String,
         *      },
         *      ....
         *     ]
         *
         *
         */
        Route::get('wishlist', 'WishlistController@getFavs');

        /**
         * @api {POST} /api/wishlist
         * @apiDescription Endpoint para retorno dos produtos na lista de favoritos do usuário
         * @apiGroup  management
         * @apiName   wishlist
         * @apiParam {String} id_product Id único do produto para favoritar.
         *
         * @apiSuccessExample Success-Response:
         *     HTTP / 200 OK
         *     [
         *        {
         *          true
         *      },
         *     ]
         *
         *
         */
        Route::post('wishlist', 'WishlistController@handleFav');
    });
});
