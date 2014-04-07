<?php

namespace spec\IdeaMap\Idea;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use IdeaMap\Idea;
use IdeaMap\Command\AddSubIdea;

class CommandAdapterSpec extends ObjectBehavior
{
    function let()
    {
        $idea = new Idea(1, 'An Idea', []);
        $this->beConstructedWith($idea);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\Idea\CommandAdapter');
    }

    function it_accepts_new_children()
    {
        $this->jsonSerialize()->ideas->shouldHaveCount(0);

        $this->addSubIdea(new AddSubIdea(2, 'A Child Idea', 1));

        $this->jsonSerialize()->ideas->shouldHaveCount(1);
        $this->jsonSerialize()->ideas[0]->shouldBeLike(
            new Idea(2, 'A Child Idea', [])
        );
    }
}
