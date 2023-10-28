<?php

namespace App\AiDevs\BuildingBlocks;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

readonly class SendAnswer
{
    public function __construct(private HttpClientInterface $aiDevsClient)
    {
    }

    public function __invoke(string $token, mixed $answer): void
    {
        $response = $this->aiDevsClient->request('POST', sprintf('answer/%s', $token), [
            'json' => [
                'answer' => $answer,
            ],
        ]);

        $response = $response->toArray(false);

        Assert::eq($response['code'], 0, $response['msg'] ?? 'undefined error');
    }
}
