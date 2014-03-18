<?php

namespace SimpleCommand\Predis;

use SimpleCommand\CommandBus as CommandBusInterface;
use SimpleCommand\Command;

class CommandBus implements CommandBusInterface
{
    public function storeIncoming(Command $command)
    {

    }

    public function notify(Command $command)
    {

    }
}
