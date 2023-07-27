<?php declare(strict_types=1);

namespace VitesseCms\Job\Repositories;

use VitesseCms\Database\Models\FindOrderIterator;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Job\Models\JobQueue;
use VitesseCms\Job\Models\JobQueueIterator;

class JobQueueRepository
{
    public function getFirstByJobId(int $jobId): ?JobQueue
    {
        JobQueue::setFindValue('jobId', $jobId);
        JobQueue::setFindValue('published', false);
        JobQueue::setFindPublished(false);
        /** @var JobQueue $jobQueue */
        $jobQueue = JobQueue::findFirst();
        if (is_object($jobQueue)):
            return $jobQueue;
        endif;

        return null;
    }

    public function getById(string $id, bool $hideUnpublished = true): ?JobQueue
    {
        JobQueue::setFindPublished($hideUnpublished);

        /** @var JobQueue $jobQueue */
        $jobQueue = JobQueue::findById($id);
        if (is_object($jobQueue)):
            return $jobQueue;
        endif;

        return null;
    }

    public function findAll(
        ?FindValueIterator $findValues = null,
        bool               $hideUnpublished = true,
        ?int               $limit = null,
        ?FindOrderIterator $findOrders = null
    ): JobQueueIterator
    {
        JobQueue::setFindPublished($hideUnpublished);
        if ($limit !== null) {
            JobQueue::setFindLimit($limit);
        }

        $this->parseFindValues($findValues);
        $this->parseFindOrders($findOrders);

        return new JobQueueIterator(JobQueue::findAll());
    }

    protected function parseFindValues(?FindValueIterator $findValues = null): void
    {
        if ($findValues !== null) :
            while ($findValues->valid()) :
                $findValue = $findValues->current();
                JobQueue::setFindValue(
                    $findValue->getKey(),
                    $findValue->getValue(),
                    $findValue->getType()
                );
                $findValues->next();
            endwhile;
        endif;
    }

    protected function parseFindOrders(?FindOrderIterator $findOrders = null): void
    {
        if ($findOrders !== null) :
            while ($findOrders->valid()) :
                $findOrder = $findOrders->current();
                JobQueue::addFindOrder(
                    $findOrder->getKey(),
                    $findOrder->getOrder()
                );
                $findOrders->next();
            endwhile;
        endif;
    }
}
