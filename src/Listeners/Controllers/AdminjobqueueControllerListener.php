<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Job\Controllers\AdminjobqueueController;

class AdminjobqueueControllerListener
{
    public function adminListFilter(Event $event, AdminjobqueueController $controller, AdminlistFormInterface $form): void
    {
        $form->addNameField($form);
        $form->addPublishedField($form);
    }
}