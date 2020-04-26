<?php

namespace App\Jobs;

use App\Services\Wishlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MailFavorites implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * MailFavorites constructor.
     * @param Wishlist $wishlist
     */
    public function __construct($email) {
        $this->email    = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Wishlist $wishlist) {
        $list = $wishlist->listFavs();

        if ($list) {
            $wishlist->sendMail(
                [
                    "list" => $list,
                    "email" => $this->email
                ]
            );
        }
    }
}
