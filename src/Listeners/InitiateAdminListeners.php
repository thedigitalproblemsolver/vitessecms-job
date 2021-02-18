<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners;

use Phalcon\Events\Manager;
use VitesseCms\Job\Controllers\AdminjobqueueController;

class InitiateAdminListeners
{
    public static function setListeners(Manager $eventsManager): void
    {
        $eventsManager->attach('adminMenu', new AdminMenuListener());
        $eventsManager->attach(AdminjobqueueController::class,new AdminjobqueueControllerListener());
    }
}
