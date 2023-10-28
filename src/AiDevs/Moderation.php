<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\Task;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'aidevs:moderation')]
class Moderation extends BaseTaskCommand
{
    public const TASK_NAME = 'moderation';

    protected function solveTask(Task $task): array
    {
        $output = $this->client->moderations()->create([
            'input' => array_values($task->params['input']),
        ]);

        return array_map(fn ($result) => (int) $result->flagged, $output->results);
    }
}
