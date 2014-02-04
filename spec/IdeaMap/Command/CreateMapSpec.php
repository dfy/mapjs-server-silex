<?php

namespace spec\IdeaMap\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateMapSpec extends ObjectBehavior
{
    private $mapTitle = 'Test map';

    function let()
    {
        $this->beConstructedWith(array('title' => $this->mapTitle));
    }

    function it_is_initializable_with_a_name()
    {
        $this->shouldHaveType('IdeaMap\Command\CreateMap');
    }

    function it_is_not_initializable_without_a_name()
    {
        $ex = new \InvalidArgumentException('Title not found in values');
        $this->shouldThrow($ex)->during('__construct', array(array()));
    }

    function it_should_give_its_name()
    {
        $this->getTitle()->shouldReturn($this->mapTitle);
    }

    function it_should_be_json_serializable()
    {
        $this->toJson()->shouldReturn('{"type":"CreateMap","title":"Test map"}');
    }
}
