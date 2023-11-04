<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\Task;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'aidevs:functions')]
class functions extends BaseTaskCommand
{
    public const TASK_NAME = 'functions';

    protected function solveTask(Task $task): array
    {

        return [
            'name' => 'addUser',
            'description' => 'add user',
            'parameters' => [
                'type' => 'object',
                'properties' => [
                    'name' => [
                        'type' => 'string',
                        'description' => 'user name'
                    ],
                    'surname' => [
                        'type' => 'string',
                        'description' => 'user surname'
                    ],
                    'year' => [
                        'type' => 'integer',
                        'description' => 'user birthday'
                    ],
                ]
            ]
        ];
    }
}
