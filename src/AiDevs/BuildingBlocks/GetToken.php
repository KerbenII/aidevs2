<?php

namespace App\AiDevs\BuildingBlocks;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

class GetToken
{
    public function __construct(private HttpClientInterface $aiDevsClient, private string $aiDevsApiKey)
    {
    }

    public function __invoke(string $taskName): string
    {
        $response = $this->aiDevsClient->request('POST', sprintf('token/%s', $taskName), [
            'json' => [
                'apikey' => $this->aiDevsApiKey,
            ],
        ]);

        $response = $response->toArray();

        Assert::eq($response['code'], 0);
        Assert::stringNotEmpty($response['token']);

        return $response['token'];
    }
}
