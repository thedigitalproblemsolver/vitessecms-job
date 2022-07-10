<?php declare(strict_types=1);

namespace VitesseCms\Job\Repositories;

use VitesseCms\Job\Models\JobQueue;

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
}
