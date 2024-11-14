<?php

namespace Webkul\Chatter\Repositories;

use Webkul\Chatter\Contracts\Message;
use Webkul\Core\Eloquent\Repository;

class MessageRepository extends Repository
{
    /**
     * Define the modal for the repository.
     *
     * @return void
     */
    public function model()
    {
        return Message::class;
    }
}
