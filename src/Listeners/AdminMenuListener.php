<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners;

use VitesseCms\Admin\Models\AdminMenu;
use VitesseCms\Admin\Models\AdminMenuNavBarChildren;
use VitesseCms\Datagroup\Models\Datagroup;
use Phalcon\Events\Event;

class AdminMenuListener
{
    public function AddChildren(Event $event, AdminMenu $adminMenu): void
    {
        if ($adminMenu->getUser()->getPermissionRole() === 'superadmin') :
            $children = new AdminMenuNavBarChildren();
            $children->addChild('Job-queue', 'admin/job/adminjobqueue/adminList')
                ->addChild('Execute job', 'job/JobQueue/execute','_blank')
            ;
            $adminMenu->addDropdown('System',$children);
        endif;
    }
}