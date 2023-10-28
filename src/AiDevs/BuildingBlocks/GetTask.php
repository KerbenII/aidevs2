<?php

namespace App\AiDevs\BuildingBlocks;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

readonly class GetTask
{
    public function __construct(private HttpClientInterface $aiDevsClient)
    {
    }

    public function __invoke(string $token): Task
    {
        $response = $this->aiDevsClient->request('GET', sprintf('task/%s', $token));
        $response = $response->toArray();

        Assert::eq($response['code'], 0);

        $params = array_filter($response, fn ($key) => !in_array($key, ['msg', 'code']), ARRAY_FILTER_USE_KEY);

        return new Task(
            $response['msg'],
            $params
        );
    }
}
