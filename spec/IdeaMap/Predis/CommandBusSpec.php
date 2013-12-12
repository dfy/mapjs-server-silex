<?php

namespace spec\IdeaMap\Predis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandBusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\Predis\CommandBus');
    }
}
