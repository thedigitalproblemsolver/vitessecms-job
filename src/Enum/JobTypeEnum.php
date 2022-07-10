<?php declare(strict_types=1);

namespace VitesseCms\Job\Enum;

use VitesseCms\Core\AbstractEnum;

class JobTypeEnum extends AbstractEnum {
    public const LISTENER = 'listener';
    public const CONTROLLER = 'controller';
}