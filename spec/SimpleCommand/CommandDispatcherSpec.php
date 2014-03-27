<?php

namespace spec\SimpleCommand;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use IdeaMap\Command\CreateMap;
use SimpleCommand\CommandProcess;

class CommandDispatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SimpleCommand\CommandDispatcher');
    }

    function it_notifies_a_registered_listener(CommandProcess $process)
    {
        $cmd = new CreateMap('Test name');

        $process->execute($cmd)->shouldBeCalled();

        $this->addListener(CreateMap::TYPE, $process)->dispatch($cmd);
    }

    function it_does_not_register_a_listener_with_an_invalid_type(CommandProcess $process)
    {
        $cmd = new CreateMap('Test name');

        $ex = new \InvalidArgumentException('Type parameter should be non-empty string');

        $this->shouldThrow($ex)->duringAddListener(new \stdClass, $process);
    }

    function it_does_not_notify_anything_if_no_listeners_exist()
    {
        $cmd = new CreateMap('Test name');

        $ex = new \OutOfRangeException('No listeners found for command ' . $cmd::TYPE);

        $this->shouldThrow($ex)->duringDispatch($cmd);
    }
}
