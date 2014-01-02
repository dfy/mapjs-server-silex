<?php

namespace SimpleCommand;

use IdeaMap\Command\Command;

interface CommandBus
{
    public function storeIncoming(Command $command);

    public function notify(Command $command);
}