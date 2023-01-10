<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners;

use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Job\Listeners\Admin\AdminMenuListener;

class InitiateListeners
{
    public static function setListeners(InjectableInterface $di): void
    {
        if ($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
    }
}
