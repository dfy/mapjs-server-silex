<?php

namespace spec\IdeaMap\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddSubIdeaSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(2, 'Idea title', 1);
    }

    function it_is_initializable_with_an_id_and_parent_id()
    {
        $this->shouldHaveType('IdeaMap\Command\AddSubIdea');
        $this->shouldHaveType('IdeaMap\Command');
    }

    function it_is_not_initializable_without_a_parent_id()
    {
        $ex = new \InvalidArgumentException('Invalid parent ID parameter');
        $this->shouldThrow($ex)->during('__construct', array(2, 'Idea title', '1'));
    }

    function it_is_not_initializable_without_an_id()
    {
        $ex = new \InvalidArgumentException('Invalid ID parameter');
        $this->shouldThrow($ex)->during('__construct', array('2', 'Idea title', 1));
    }

    function it_is_not_initializable_without_a_title()
    {
        $ex = new \InvalidArgumentException('Invalid title parameter');
        $this->shouldThrow($ex)->during('__construct', array(2, 999, 1));
    }

    function it_is_initializable_with_a_null_parent_id()
    {
        $ex = new \InvalidArgumentException('Invalid parent ID parameter');
        $this->shouldNotThrow($ex)->during('__construct', array(2, 'Idea title', null));
    }

    function it_is_not_initializable_with_a_null_id()
    {
        $ex = new \InvalidArgumentException('Invalid ID parameter');
        $this->shouldThrow($ex)->during('__construct', array(null, 'Idea title', 1));
    }

    function it_should_give_its_id()
    {
        $this->getId()->shouldReturn(2);
    }

    function it_should_give_its_title()
    {
        $this->getTitle()->shouldReturn('Idea title');
    }

    function it_should_give_its_parents_id()
    {
        $this->getParentId()->shouldReturn(1);
    }

    function it_should_be_serializable()
    {
        $serializable = (object) array(
            'type' => 'AddSubIdea',
            'id' => 2,
            'title' => 'Idea title',
            'parentId' => 1
        );

        $this->jsonSerialize()->shouldBeLike($serializable);
    }
}

/*
 * fields:
 * - parent id: nullable if just adding to map
 * - id: set a session id client side, then assign "real" id server side
 * -- but how to reconcile old client side id and replacement server side id? new event? does each client need to
 *    subscribe to a session event feed? overkill for current needs. just include in main feed for now. or handle
 *    it all client side
 * - title: the content, just called title in the version I have... not on this command?
 * - attr: not on this command?
 * - ideas: not on this command
 */
