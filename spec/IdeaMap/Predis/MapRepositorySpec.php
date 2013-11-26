<?php

namespace spec\IdeaMap\Predis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Predis\Client;

class MapRepositorySpec extends ObjectBehavior
{
    public function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\Predis\MapRepository');
    }

    /*function let(ProjectManager $manager)
    {
        $this->beConstructedWith('a project name', $manager);
    }

    function it_has_a_link_to_a_manager(ProjectManager $manager)
    {
        $this->getManager()->shouldReturn($manager);
    }*/
}
