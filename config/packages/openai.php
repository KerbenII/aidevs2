<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set(\OpenAI\Client::class)
        ->class(OpenAI::class)
        ->factory([OpenAI::class, 'client'])
        ->arg('$apiKey', '%env(OPENAI_API_KEY)%');
};
