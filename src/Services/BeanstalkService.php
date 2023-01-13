<?php declare(strict_types=1);

namespace VitesseCms\Job\Services;

use Phalcon\Http\RequestInterface;
use Phalcon\Mvc\User\Component;
use Pheanstalk\Contract\JobIdInterface;
use Pheanstalk\Contract\PheanstalkInterface;
use Pheanstalk\Job;
use Pheanstalk\Pheanstalk;
use VitesseCms\Core\AbstractController;
use VitesseCms\Job\Enum\JobTypeEnum;
use VitesseCms\Job\Factories\JobQueueFactory;
use VitesseCms\User\Models\User;

class BeanstalkService
{
    /**
     * @var Pheanstalk
     */
    private $client;

    public function __construct(Pheanstalk $client)
    {
        $this->client = $client;
    }

    public function createByController(AbstractController $controller): int
    {
        $router = $controller->router;
        $user = $controller->user;
        $request = $controller->request;

        return $this->create($router, $request, $user);
    }

    public function create(
        RouterService    $router,
        RequestInterface $request,
        ?User            $user = null,
        array            $jobOptions = []
    ): int
    {
        $userId = null;
        if ($user) :
            $userId = $user->getId();
        endif;

        $data = [
            'jobType' => JobTypeEnum::CONTROLLER,
            'module' => $router->getModuleName(),
            'controller' => $router->getControllerName(),
            'action' => $router->getActionName(),
            'params' => $router->getParams(),
            'userId' => $userId,
            'post' => $request->getPost(),
            'eventInputs' => (new Component())->content->getEventInputs(),
        ];

        $delay = $jobOptions['delay'] ?? PheanstalkInterface::DEFAULT_DELAY;
        $job = $this->handlePut($data, $delay);

        JobQueueFactory::create(
            $router->getModuleName() .
            '/' . $router->getControllerName() .
            '/' . $router->getActionName(),
            serialize($router->getParams()),
            $job->getId(),
            '',
            false,
            $delay
        )->save();

        return $job->getId();
    }

    public function createListenerJob(
        string $name,
        string $eventTrigger,
               $eventVehicle,
        array  $jobOptions = []
    ): int
    {
        $delay = $jobOptions['delay'] ?? PheanstalkInterface::DEFAULT_DELAY;

        $job = $this->handlePut(
            [
                'jobType' => JobTypeEnum::LISTENER,
                'eventTrigger' => $eventTrigger
            ],
            $delay
        );

        JobQueueFactory::create(
            $name,
            serialize($eventVehicle),
            $job->getId(),
            '',
            false,
            $delay
        )->save();

        return $job->getId();
    }

    public function peekReady(): ?Job
    {
        return $this->client->peekReady();
    }

    public function delete(JobIdInterface $job)
    {
        $this->client->delete($job);
    }

    private function handlePut($data, int $delay = 0): Job
    {
        if (!is_string($data)) :
            $data = serialize($data);
        endif;

        return $this->client->put(
            $data,
            PheanstalkInterface::DEFAULT_PRIORITY,
            $delay
        );
    }
}
