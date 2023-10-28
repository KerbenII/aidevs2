<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\Task;
use Symfony\Component\Console\Attribute\AsCommand;
use Webmozart\Assert\Assert;

#[AsCommand(name: 'aidevs:liar')]
class Liar extends BaseTaskCommand
{
    public const TASK_NAME = 'liar';

    protected function solveTask(Task $task): string
    {
        dump($task);

        $question = 'Odpowiedz jednym wyrazem co jest stolicą Polski';
        $response = $this->aiDevsClient->request('POST', sprintf('task/%s', $this->tokenForTask), [
            'body' => [
                'question' => 'Odpowiedz jednym wyrazem co jest stolicą Polski',
            ],
        ]);

        $response = $response->toArray();
        Assert::keyExists($response, 'answer');
        Assert::string($response['answer']);

        dump($response['answer']);
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => <<<EOT
                    Answer "YES" or "NO":
                    Is this ({$response['answer']}) the correct answer to the question ($question)?
                    EOT
                ],
            ],
            'max_tokens' => 120,
        ]);

        $solution = '';
        foreach ($response->choices as $choice) {
            $solution .= $choice->message->content;
        }

        return $solution;
    }
}
