<?php

namespace spec\IdeaMap;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IdeaSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1, 'An Idea', array());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\Idea');
    }

    function it_is_serializable()
    {
        $serializable = (object) array(
            'id' => 1,
            'title' => 'An Idea',
            'ideas' => array()
        );

        $this->jsonSerialize()->shouldBeLike($serializable);
    }
}
