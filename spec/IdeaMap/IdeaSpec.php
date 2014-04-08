<?php

namespace spec\IdeaMap;

use IdeaMap\Idea;
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

    function it_accepts_new_children()
    {
        $this->jsonSerialize()->ideas->shouldHaveCount(0);

        $childIdea = new Idea(2, 'A Child Idea', array());
        $this->addChild($childIdea);

        $this->jsonSerialize()->ideas->shouldHaveCount(1);
        $this->jsonSerialize()->ideas[0]->shouldBeLike($childIdea);
    }

    function its_title_can_be_updated()
    {
        $newTitle = 'A new title';
        $this->updateTitle($newTitle);
        $this->jsonSerialize()->title->shouldEqual($newTitle);
    }

    function it_finds_itself()
    {
        $this->find(1)->shouldEqual($this);
    }

    function it_finds_subideas()
    {
        $subIdea = new Idea(2, 'A Child Idea', array());

        $this->addChild($subIdea);

        $this->find(2)->shouldEqual($subIdea);
    }

    function it_only_finds_subideas_that_exist()
    {
        $this->find(999)->shouldEqual(null);
    }
}
