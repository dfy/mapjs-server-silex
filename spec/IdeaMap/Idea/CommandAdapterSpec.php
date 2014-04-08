<?php

namespace spec\IdeaMap\Idea;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use IdeaMap\Idea;
use IdeaMap\Command\AddSubIdea;
use IdeaMap\Command\SetIdeaTitle;

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

    function it_accepts_new_children_of_children()
    {
        $this->addSubIdea(new AddSubIdea(2, 'A Child Idea', 1));
        $this->jsonSerialize()->ideas->shouldHaveCount(1);

        $this->addSubIdea(new AddSubIdea(3, 'Another Idea', 2));
        $this->jsonSerialize()->ideas->shouldHaveCount(1);
        $this->jsonSerialize()->ideas[0]->jsonSerialize()->ideas->shouldHaveCount(1);
    }

    function it_only_accepts_children_if_the_parent_exists()
    {
        $ex = new \InvalidArgumentException('Idea not found with ID 999');
        $this->shouldThrow($ex)->duringAddSubIdea(
            new AddSubIdea(2, 'A Child Idea', 999)
        );
    }

    function it_updates_the_title_of_the_root_idea()
    {
        $newTitle = 'A new title';
        $this->setIdeaTitle(
            new SetIdeaTitle(1, $newTitle)
        );
        $this->jsonSerialize()->title->shouldBe($newTitle);
    }
}
