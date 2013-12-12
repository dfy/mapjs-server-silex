<?php

namespace IdeaMap;

use IdeaMap\Command\Command;

interface CommandBus
{
    public function storeIncoming(Command $command);

    public function storeIncomingAndNotify(Command $command);
}