<?php declare(strict_types=1);

namespace VitesseCms\Job;

use Phalcon\DiInterface;
use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\AbstractModule;
use VitesseCms\Job\Repositories\JobQueueRepository;
use VitesseCms\Job\Repositories\RepositoryCollection;
use VitesseCms\User\Repositories\UserRepository;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, 'Datagroup');
        if (AdminUtil::isAdminPage()) :

        else :
            $di->setShared('repositories', new RepositoryCollection(
                new JobQueueRepository(),
                new UserRepository()
            ));
        endif;
    }
}