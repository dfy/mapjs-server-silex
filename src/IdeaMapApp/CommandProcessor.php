<?php

namespace IdeaMapApp;

use SimpleCommand\CommandList;
use SimpleCommand\CommandDispatcher;
use SimpleCommand\EventPublisher;

class CommandProcessor
{
    private $commandList;
    private $commandDispatcher;
    private $eventPublisher;

    public function __construct(
        CommandList $commandList,
        CommandDispatcher $commandDispatcher,
        EventPublisher $eventPublisher
    ) {
        $this->commandList = $commandList;
        $this->commandDispatcher = $commandDispatcher;
        $this->eventPublisher = $eventPublisher;
    }

    public function run()
    {
        $cmd = $this->commandList->fetchNext();

        $this->commandDispatcher->dispatch($cmd);
        $this->eventPublisher->publish($cmd);
    }
}
