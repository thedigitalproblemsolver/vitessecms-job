<?php declare(strict_types=1);

namespace VitesseCms\Job\Listeners\Models;

use VitesseCms\Job\Repositories\JobQueueRepository;

class JobQueueListener
{
    public function __construct(private readonly JobQueueRepository $jobQueueRepository)
    {
    }

    public function getRepository(): JobQueueRepository
    {
        return $this->jobQueueRepository;
    }
}