<?php

namespace spec\IdeaMapApp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use SimpleCommand\CommandList;
use SimpleCommand\CommandDispatcher;

class CommandProcessorSpec extends ObjectBehavior
{
    function let(
        CommandList $commandList,
        CommandDispatcher $commandDispatcher,
        CommandDispatcher $eventDispatcher
    ) {
        $this->beConstructedWith($commandList, $commandDispatcher, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMapApp\CommandProcessor');
    }
}
