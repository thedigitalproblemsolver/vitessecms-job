<?php declare(strict_types=1);

namespace VitesseCms\Job\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Job\Forms\JobQueueForm;
use VitesseCms\Job\Models\JobQueue;

class AdminjobqueueController extends AbstractAdminController
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = JobQueue::class;
        $this->classForm = JobQueueForm::class;
        $this->listOrder = 'createdAt';
        $this->listOrderDirection = -1;
        $this->displayEditButton = false;
    }
}
