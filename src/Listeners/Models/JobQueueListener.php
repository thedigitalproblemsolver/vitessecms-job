<?php

declare(strict_types=1);

namespace VitesseCms\Job\Listeners\Models;

use VitesseCms\Job\Repositories\JobQueueRepository;
use VitesseCms\Job\Services\BeanstalkService;

class JobQueueListener
{
    public function __construct(
        private readonly JobQueueRepository $jobQueueRepository,
        private readonly BeanstalkService $beanstalkService
    ) {
    }

    public function getRepository(): JobQueueRepository
    {
        return $this->jobQueueRepository;
    }

    public function attach(): BeanstalkService
    {
        return $this->beanstalkService;
    }
}