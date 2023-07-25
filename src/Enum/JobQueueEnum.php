<?php declare(strict_types=1);

namespace VitesseCms\Job\Enum;

enum JobQueueEnum: string
{
    case LISTENER = 'JobQueueListener';
    case GET_REPOSITORY = 'JobQueueListener:getRepository';
}