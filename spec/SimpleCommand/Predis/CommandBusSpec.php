<?php

namespace spec\SimpleCommand\Predis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use IdeaMap\Command\Command;

class CommandBusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SimpleCommand\Predis\CommandBus');
    }
}
