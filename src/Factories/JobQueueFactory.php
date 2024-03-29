<?php declare(strict_types=1);

namespace VitesseCms\Job\Factories;

use DateTime;
use VitesseCms\Job\Models\JobQueue;

class JobQueueFactory
{
    public static function create(
        string $name,
        string $params,
        int $jobId,
        string $message = '',
        bool $published = true,
        int $delay = 0
    ): JobQueue
    {
        $datetime = new DateTime();
        if ($delay > 0) :
            $datetime->modify('+' . $delay . ' seconds');
        endif;

        return (new JobQueue())
            ->setParams($params)
            ->setJobId($jobId)
            ->setMessage($message)
            ->setParseDate($datetime->format('Y-m-d H:i:s'))
            ->setPublished($published)
            ->setName($name);
    }
}
