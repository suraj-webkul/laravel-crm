<?php

namespace Webkul\Contact\Repositories;

use Webkul\Contact\Contracts\Message;
use Webkul\Core\Eloquent\Repository;

class MessageRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return Message::class;
    }
}
