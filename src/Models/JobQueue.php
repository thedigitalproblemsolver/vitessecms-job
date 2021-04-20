<?php declare(strict_types=1);

namespace VitesseCms\Job\Models;

use VitesseCms\Database\AbstractCollection;

class JobQueue extends AbstractCollection
{
    /**
     * @var string
     */
    public $params;

    /**
     * @var int
     */
    public $jobId;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $parseDate;

    /**
     * @var string
     */
    public $name;

    public function setParams(string $params): JobQueue
    {
        $this->params = $params;

        return $this;
    }

    public function setJobId(int $jobId): JobQueue
    {
        $this->jobId = $jobId;

        return $this;
    }

    public function setMessage(string $message): JobQueue
    {
        $this->message = $message;

        return $this;
    }

    public function setParseDate(string $parseDate): JobQueue
    {
        $this->parseDate = $parseDate;

        return $this;
    }

    public function setName(string $name): JobQueue
    {
        $this->name = $name;

        return $this;
    }
}
