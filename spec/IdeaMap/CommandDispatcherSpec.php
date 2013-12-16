<?php

namespace spec\IdeaMap;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use IdeaMap\Command\CreateMap;
use IdeaMap\CommandProcess;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CommandDispatcherSpec extends ObjectBehavior
{
    private $eventPrefix = 'eventPrefix.';

    function let(EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dispatcher, $this->eventPrefix);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\CommandDispatcher');
    }

    function it_registers_a_command_listener_with_the_event_prefix(CommandProcess $process, $dispatcher)
    {
        $eventName = $this->eventPrefix . CreateMap::TYPE;
        $dispatcher->addListener($eventName, array($process, 'execute'))->shouldBeCalled();

        $this->addListener(CreateMap::TYPE, $process);
    }

    function it_registers_a_command_listener_without_the_event_prefix(CommandProcess $process, $dispatcher)
    {
        $this->beConstructedWith($dispatcher);

        $eventName = CreateMap::TYPE;
        $dispatcher->addListener($eventName, array($process, 'execute'))->shouldBeCalled();

        $this->addListener(CreateMap::TYPE, $process);
    }
}
