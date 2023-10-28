<?php

namespace App\AiDevs\BuildingBlocks;

use OpenAI\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

abstract class BaseTaskCommand extends Command
{
    public const TASK_NAME = null;

    public function __construct(protected Client $client,
        private GetToken $getToken,
        private GetTask $getTask,
        private SendAnswer $sendAnswer,
        string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // todo: maybe extract from class/command name?
        Assert::notNull(static::TASK_NAME, 'add TASK_NAME const to your Command');

        $token = ($this->getToken)(static::TASK_NAME);
        $task = ($this->getTask)($token);

        dump($task);

        ($this->sendAnswer)($token, $this->solveTask($task));

        $output->write('Congrats, all green!');

        return Command::SUCCESS;
    }

    abstract protected function solveTask(Task $task): mixed;
}
