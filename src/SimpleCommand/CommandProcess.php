<?php

namespace SimpleCommand;

use SimpleCommand\Command;

interface CommandProcess 
{
    public function execute(Command $command);
}
