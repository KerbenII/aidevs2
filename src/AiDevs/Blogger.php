<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\Task;
use Symfony\Component\Console\Attribute\AsCommand;
use Webmozart\Assert\Assert;

#[AsCommand(name: 'aidevs:blogger')]
class Blogger extends BaseTaskCommand
{
    public const TASK_NAME = 'blogger';

    protected function solveTask(Task $task): array
    {
        Assert::isArray($task->params['blog']);

        $solution = [];
        $chapters = $task->params['blog'];
        foreach ($chapters as $key => $paragraph) {
            $numberInRow = $key + 1 == count($chapters) ? 'last' : $key + 1;
            // todo: should be async
            $response = $this->client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => <<<EOT
                    Your task is to write a paragraph article for the blog.
                    Paragraph title: $paragraph
                    Your paragraph is $numberInRow in order.
                    Write only paragraph content.
                    EOT
                    ],
                ],
                'max_tokens' => 120,
            ]);

            foreach ($response->choices as $choice) {
                $solution[] = $choice->message->content;
            }
        }

        return $solution;
    }
}
