<?php

namespace spec\IdeaMapApp\Predis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use IdeaMapApp\Command\Command;

class CommandBusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMapApp\Predis\CommandBus');
    }
}
