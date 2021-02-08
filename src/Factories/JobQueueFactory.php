<?php declare(strict_types=1);

namespace VitesseCms\Job\Factories;

use VitesseCms\Job\Models\JobQueue;

class JobQueueFactory
{
    public static function create(
        string $name,
        string $params,
        int $jobId,
        string $message = '',
        bool $published = true,
        ?int $delay = null
    ): JobQueue {
        $datetime = new \DateTime();
        if($delay) :
            $datetime->modify('+'.$delay.' seconds');
        endif;

        return (new JobQueue())
            ->setParams($params)
            ->setJobId($jobId)
            ->setMessage($message)
            ->setParseDate($datetime->format('Y-m-d H:i:s'))
            ->setPublished($published)
            ->setName($name)
        ;
    }
}
