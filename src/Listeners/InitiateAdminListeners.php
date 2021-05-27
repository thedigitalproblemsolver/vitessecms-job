<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners;

use Phalcon\Events\Manager;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Job\Controllers\AdminjobqueueController;
use VitesseCms\Job\Listeners\Admin\AdminMenuListener;
use VitesseCms\Job\Listeners\Controllers\AdminjobqueueControllerListener;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(AdminjobqueueController::class, new AdminjobqueueControllerListener());
    }
}
