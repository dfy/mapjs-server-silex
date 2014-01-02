<?php

namespace SimpleCommand;

use IdeaMap\Command\Command;

interface CommandProcess 
{
    public function execute(Command $command);
}
