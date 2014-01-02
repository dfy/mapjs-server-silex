<?php

namespace IdeaMap\Predis;

use IdeaMap\CommandBus as CommandBusInterface;
use IdeaMap\Command\Command;

class CommandBus implements CommandBusInterface
{
    public function storeIncoming(Command $command)
    {

    }

    public function notify(Command $command)
    {

    }
}
