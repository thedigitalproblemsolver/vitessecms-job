<?php declare(strict_types=1);

namespace VitesseCms\Job\Repositories;

use VitesseCms\Database\Interfaces\BaseRepositoriesInterface;
use VitesseCms\User\Repositories\UserRepository;

class RepositoryCollection implements BaseRepositoriesInterface
{
    /**
     * @var JobQueueRepository
     */
    public $jobqueue;

    /**
     * @var UserRepository
     */
    public $user;

    public function __construct(
        JobQueueRepository $jobQueueRepository,
        UserRepository $userRepository
    ) {
        $this->jobqueue = $jobQueueRepository;
        $this->user = $userRepository;
    }
}
