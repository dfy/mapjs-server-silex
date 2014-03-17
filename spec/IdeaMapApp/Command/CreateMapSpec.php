<?php

namespace spec\IdeaMapApp\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateMapSpec extends ObjectBehavior
{
    private $mapTitle = 'Test map';

    function let()
    {
        $this->beConstructedWith($this->mapTitle);
    }

    function it_is_initializable_with_a_name()
    {
        $this->shouldHaveType('IdeaMapApp\Command\CreateMap');
    }

    function it_is_not_initializable_without_a_name()
    {
        $ex = new \InvalidArgumentException('Invalid title parameter');
        $this->shouldThrow($ex)->during('__construct', array(999));
    }

    function it_should_give_its_name()
    {
        $this->getTitle()->shouldReturn($this->mapTitle);
    }

    function it_should_be_serializable()
    {
        $serializable = (object) array(
            'type' => 'CreateMap',
            'title' => 'Test map'
        );

        $this->jsonSerialize()->shouldBeLike($serializable);
    }
}
