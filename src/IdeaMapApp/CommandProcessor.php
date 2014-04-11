<?php

namespace IdeaMapApp;

use SimpleCommand\CommandList;
use SimpleCommand\CommandDispatcher;

class CommandProcessor
{
    private $commandList;
    private $commandDispatcher;
    private $eventDispatcher;

    public function __construct(
        CommandList $commandList,
        CommandDispatcher $commandDispatcher,
        CommandDispatcher $eventDispatcher
    ) {
        $this->commandList = $commandList;
        $this->commandDispatcher = $commandDispatcher;
        $this->eventDispatcher = $eventDispatcher;
    }
}
