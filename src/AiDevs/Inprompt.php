<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\Task;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'aidevs:inprompt')]
class Inprompt extends BaseTaskCommand
{
    public const TASK_NAME = 'inprompt';

    //todo: some abstraction over OpenAi::Client?
    protected function solveTask(Task $task): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'What is the name of the person to whom this sentence refers? Answer should contain first name only.'
                ],
                [
                    'role' => 'user',
                    'content' => $task->params['question']
                ]
            ],
            'max_tokens' => 120,
        ]);


        $name = $response->choices[0]->message->content;

        $relevant = [];
        foreach ($task->params['input'] as $sentence) {
            if (strtok($sentence, " ") === $name) {
                $relevant[] = $sentence;
            }
        }

        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $task->instruction. implode("\n", $relevant)
                ],
                [
                    'role' => 'user',
                    'content' => $task->params['question']
                ]
            ],
            'max_tokens' => 120,
        ]);

        return $response->choices[0]->message->content;
    }
}
