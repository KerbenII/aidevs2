<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\Task;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'aidevs:helloapi')]
class HelloApi extends BaseTaskCommand
{
    public const TASK_NAME = 'helloapi';

    protected function solveTask(Task $task): mixed
    {
        return $task->params['cookie'];
    }
}
