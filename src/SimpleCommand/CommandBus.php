<?php

namespace SimpleCommand;

use SimpleCommand\Command;

interface CommandBus
{
    public function storeIncoming(Command $command);

    public function notify(Command $command);
}