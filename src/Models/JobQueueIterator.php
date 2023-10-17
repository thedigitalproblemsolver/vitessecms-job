<?php
declare(strict_types=1);

namespace VitesseCms\Job\Models;

use ArrayIterator;

class JobQueueIterator extends ArrayIterator
{
    public function __construct(array $items)
    {
        parent::__construct($items);
    }

    public function current(): JobQueue
    {
        return parent::current();
    }
}