<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners\Admin;

use Phalcon\Events\Event;
use VitesseCms\Admin\Models\AdminMenu;
use VitesseCms\Admin\Models\AdminMenuNavBarChildren;

class AdminMenuListener
{
    public function AddChildren(Event $event, AdminMenu $adminMenu): void
    {
        $children = new AdminMenuNavBarChildren();
        $children->addChild('Job-queue', 'admin/job/adminjobqueue/adminList')
            ->addChild('Execute job', 'job/JobQueue/execute', '_blank');
        $adminMenu->addDropdown('System', $children);
    }
}