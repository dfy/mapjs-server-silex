<?php

namespace spec\IdeaMap;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MapSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('An Idea');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\Map');
    }
}
