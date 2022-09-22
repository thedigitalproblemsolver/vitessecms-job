<?php declare(strict_types=1);

namespace VitesseCms\Job\Controllers;

use DateTime;
use Phalcon\Exception;
use VitesseCms\Core\AbstractController;
use VitesseCms\Core\AbstractModule;
use VitesseCms\Database\Utils\MongoUtil;
use VitesseCms\Job\Enum\JobTypeEnum;
use VitesseCms\Job\Models\JobQueue;
use VitesseCms\Job\Repositories\RepositoriesInterface;
use VitesseCms\Job\Services\BeanstalkService;

class JobqueueController extends AbstractController implements RepositoriesInterface
{
    public function executeAction(): void
    {
        $this->parseJobs($this->jobQueue);

        $this->disableView();
    }

    public function parseJobs(BeanstalkService $beanstalkService): void
    {
        $job = $beanstalkService->peekReady();
        if ($job !== null):
            try {
                $task = $job->getBody();
                if ($task['jobType'] === JobTypeEnum::LISTENER) :
                    $jobQueue = $this->repositories->jobqueue->getFirstByJobId((int)$job->getId());
                    if($jobQueue !== null) :
                        $eventVehicle = unserialize($jobQueue->getParams());
                        $this->eventsManager->fire($task['eventTrigger'], $eventVehicle);
                        $this->setJobFinished($jobQueue, $job, 'Event ' . $task['eventTrigger'] . ' has run');
                    else :
                        $job->delete();
                        $this->log->message('Beanstalk job with ID is '.$job->getId().' deleted');
                    endif;
                else :
                    $_POST = $task['post'];
                    $_REQUEST = $_POST;
                    if (isset($task['eventInputs'])) :
                        $this->content->setEventInputs($task['eventInputs']);
                    endif;

                    $controllerNamespace = 'VitesseCms\\' .
                        str_replace(
                            'Communicationcommunication',
                            'Communication',
                            ucfirst($task['module'])
                        ) .
                        '\\Controllers\\' .
                        ucfirst($task['controller'] . 'Controller');
                    /** @var AbstractController $controller */
                    $controller = new $controllerNamespace();
                    $controller->setIsJobProcess(true);
                    $action = $task['action'] . 'Action';
                    if (isset($task['userId']) && MongoUtil::isObjectId((string)$task['userId'])) :
                        $controller->user = $this->repositories->user->getById($task['userId']);
                    endif;

                    $moduleNamespace = 'VitesseCms\\' .
                        str_replace(
                            'Communicationcommunication',
                            'Communication',
                            ucfirst($task['module'])
                        ) . '\\Module';
                    if (class_exists($moduleNamespace)) :
                        /** @var AbstractModule $module */
                        $module = new $moduleNamespace();
                        $controller->repositories = $module->getRepositories();
                    endif;

                    ob_start();
                    $controller->$action($task['params'][0]);
                    $message = ob_get_contents();
                    ob_end_clean();

                    $jobQueue = $this->repositories->jobqueue->getFirstByJobId((int)$job->getId());
                    $this->setJobFinished($jobQueue, $job, 'Event ' . $task['eventTrigger'] . ' has run');
                endif;
            } catch (Exception $exception) {
                $jobQueue = $this->repositories->jobqueue->getFirstByJobId((int)$job->getId());
                if ($jobQueue) :
                    $jobQueue->set('message', 'task deleted')->save();
                endif;

                $job->delete();
                $this->log->message('Beanstalk job with ID is '.$job->getId().' deleted');
            }
        endif;

        echo '<br />JobQueues completed';

        $this->view->disable();
    }

    protected function setJobFinished(JobQueue $jobQueue, $job, string $message = ''): void
    {
        $jobQueue->set('published', true)
            ->set('parsed', (new DateTime())->format('Y-m-d H:i:s'))
            ->set('message', trim(strip_tags($message)))
            ->save();
        echo 'Job with id <a href="' . $this->url->getBaseUri() . 'admin/core/adminjobqueue/edit/' . $jobQueue->getId() . '" target="_blank ">' . $jobQueue->getId() . '</a> is executed.';
        $job->delete();
    }
}
