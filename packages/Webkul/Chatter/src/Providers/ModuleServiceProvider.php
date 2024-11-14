<?php

namespace Webkul\Chatter\Providers;

use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\Chatter\Models\Message::class,
        \Webkul\Chatter\Models\Task::class,
    ];
}
