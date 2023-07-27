<?php declare(strict_types=1);

namespace VitesseCms\Job\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Interfaces\AdminModelListInterface;
use VitesseCms\Admin\Interfaces\AdminModelReadOnlyInterface;
use VitesseCms\Admin\Traits\TraitAdminModelList;
use VitesseCms\Admin\Traits\TraitAdminModelReadOnly;
use VitesseCms\Core\AbstractControllerAdmin;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Database\Models\FindOrder;
use VitesseCms\Database\Models\FindOrderIterator;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Job\Enum\JobQueueEnum;
use VitesseCms\Job\Forms\JobQueueForm;
use VitesseCms\Job\Models\JobQueue;
use VitesseCms\Job\Repositories\JobQueueRepository;
use VitesseCms\Log\Enums\LogEnum;
use VitesseCms\Log\Repositories\LogRepository;

class AdminjobqueueController extends AbstractControllerAdmin implements
    AdminModelListInterface,
    AdminModelReadOnlyInterface
{
    use TraitAdminModelList;
    use TraitAdminModelReadOnly;

    private readonly JobQueueRepository $jobQueueRepository;

    public function onConstruct()
    {
        parent::onConstruct();

        $this->jobQueueRepository = $this->eventsManager->fire(JobQueueEnum::GET_REPOSITORY->value, new \stdClass());
    }

    public function getModelList( ?FindValueIterator $findValueIterator): \ArrayIterator
    {
        return $this->jobQueueRepository->findAll(
            $findValueIterator,
            false,
            9999,
            new FindOrderIterator([new FindOrder('createdAt', -1)])
        );
    }

    public function getModel(string $id): ?AbstractCollection{
        return $this->jobQueueRepository->getById($id, false);
    }
}
