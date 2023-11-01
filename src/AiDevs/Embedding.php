<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\Task;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'aidevs:embedding')]
class Embedding extends BaseTaskCommand
{
    public const TASK_NAME = 'embedding';

    protected function solveTask(Task $task): array
    {
        $response = $this->client->embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => 'Hawaiian pizza',
        ]);

        return $response->embeddings[0]->embedding;
    }
}
