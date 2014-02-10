<?php

namespace spec\IdeaMap\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SetIdeaTitleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(2, 'Test idea');
    }

    function it_is_initializable_with_an_id_and_a_title()
    {
        $this->shouldHaveType('IdeaMap\Command\SetIdeaTitle');
    }

    function it_is_not_initializable_without_a_valid_id()
    {
        $ex = new \InvalidArgumentException('Invalid ID parameter');
        $this->shouldThrow($ex)->during('__construct', array('2', 'Test idea'));
    }

    function it_is_not_initializable_without_a_title()
    {
        $ex = new \InvalidArgumentException('Invalid title parameter');
        $this->shouldThrow($ex)->during('__construct', array(2, 2));
    }

    function it_should_give_its_id()
    {
        $this->getId()->shouldReturn(2);
    }

    function it_should_give_its_title()
    {
        $this->getTitle()->shouldReturn('Test idea');
    }
}
