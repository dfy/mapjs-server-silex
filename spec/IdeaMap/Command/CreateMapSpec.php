<?php

namespace spec\IdeaMap\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateMapSpec extends ObjectBehavior
{
    private $mapName = 'Test map';

    function let()
    {
        $this->beConstructedWith(array('name' => $this->mapName));
    }

    function it_is_initializable_with_a_name()
    {
        $this->shouldHaveType('IdeaMap\Command\CreateMap');
    }

    function it_is_not_initializable_without_a_name()
    {
        $ex = new \InvalidArgumentException('Name not found in values');
        $this->shouldThrow($ex)->during('__construct', array(array()));
    }

    function it_should_give_its_name()
    {
        $this->getName()->shouldReturn($this->mapName);
    }
}
