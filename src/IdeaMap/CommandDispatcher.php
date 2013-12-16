<?php

namespace IdeaMap;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CommandDispatcher
{
    protected $dispatcher;

    protected $eventPrefix;

    public function __construct(EventDispatcherInterface $dispatcher, $eventPrefix = '')
    {
        $this->dispatcher = $dispatcher;
        $this->eventPrefix = $eventPrefix;
    }

    public function addListener($commandType, CommandProcess $process)
    {
        $this->dispatcher->addListener(
            $this->eventPrefix . $commandType,
            array($process, 'execute')
        );
    }
}
