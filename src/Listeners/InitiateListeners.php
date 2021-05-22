<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners;

use Phalcon\Events\Manager;

class InitiateListeners
{
    public static function setListeners(Manager $eventsManager): void
    {
        $eventsManager->attach('adminMenu', new AdminMenuListener());
    }
}
