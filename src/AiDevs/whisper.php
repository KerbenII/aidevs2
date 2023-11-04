<?php

namespace App\AiDevs;

use App\AiDevs\BuildingBlocks\BaseTaskCommand;
use App\AiDevs\BuildingBlocks\GetTask;
use App\AiDevs\BuildingBlocks\GetToken;
use App\AiDevs\BuildingBlocks\SendAnswer;
use App\AiDevs\BuildingBlocks\Task;
use OpenAI\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(name: 'aidevs:whisper')]
class whisper extends BaseTaskCommand
{
    public function __construct(private HttpClientInterface $httpClient, Client $client, GetToken $getToken, GetTask $getTask, SendAnswer $sendAnswer, HttpClientInterface $aiDevsClient, string $name = null)
    {
        parent::__construct($client, $getToken, $getTask, $sendAnswer, $aiDevsClient, $name);
    }

    public const TASK_NAME = 'whisper';

    protected function solveTask(Task $task): string
    {
        $response = $this->httpClient->request('GET', 'https://zadania.aidevs.pl/data/mateusz.mp3');
        $audioContent = $response->getContent();
        file_put_contents('mateusz.mp3', $audioContent);

        $response = $this->client->audio()->transcribe([
            'model' => 'whisper-1',
            'file' => fopen('mateusz.mp3', 'r')
        ]);

        unlink('mateusz.mp3');

        return $response->text;
    }
}
