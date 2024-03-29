<?php
declare(strict_types=1);

namespace VitesseCms\Job\Listeners;

use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Job\Controllers\AdminjobqueueController;
use VitesseCms\Job\Enum\JobQueueEnum;
use VitesseCms\Job\Listeners\Admin\AdminMenuListener;
use VitesseCms\Job\Listeners\Controllers\AdminjobqueueControllerListener;
use VitesseCms\Job\Listeners\Models\JobQueueListener;
use VitesseCms\Job\Repositories\JobQueueRepository;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(AdminjobqueueController::class, new AdminjobqueueControllerListener());
        $di->eventsManager->attach(
            JobQueueEnum::LISTENER->value,
            new JobQueueListener(new JobQueueRepository(), $di->jobQueue)
        );
    }
}
