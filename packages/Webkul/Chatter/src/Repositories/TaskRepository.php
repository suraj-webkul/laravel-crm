<?php

namespace Webkul\Chatter\Repositories;

use Webkul\Chatter\Contracts\Task;
use Webkul\Core\Eloquent\Repository;

class TaskRepository extends Repository
{
    /**
     * Define the modal for the repository.
     *
     * @return void
     */
    public function model()
    {
        return Task::class;
    }
}
