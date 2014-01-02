<?php

namespace SimpleCommand;

use IdeaMap\Command\Command;

// rename to process executor?
class CommandDispatcher
{
    protected $listeners = array();

    public function addListener($commandType, CommandProcess $process)
    {
        if (!is_string($commandType) || strlen($commandType) === 0) {
            throw new \InvalidArgumentException('Type parameter should be non-empty string');
        }

        if (!isset($this->listeners[$commandType])) {
            $this->listeners[$commandType] = array();
        }

        $this->listeners[$commandType][] = $process;

        return $this;
    }

    public function dispatch(Command $cmd)
    {
        $commandType = $cmd::TYPE;

        if (!isset($this->listeners[$commandType])) {
            throw new \OutOfRangeException('No listeners found for command ' . $cmd::TYPE);
        }

        foreach ($this->listeners[$commandType] as $listener) {
            $listener->execute($cmd);
        }
    }
}
