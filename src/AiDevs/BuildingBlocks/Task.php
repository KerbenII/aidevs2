<?php

namespace App\AiDevs\BuildingBlocks;

readonly class Task
{
    public function __construct(
        public string $instruction,
        public array $params
    ) {
    }
}
