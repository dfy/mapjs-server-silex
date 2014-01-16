<?php

namespace spec\IdeaMap\Service;

use IdeaMap\Process\CreateMap as CreateMapProcess;
use IdeaMap\Command\CreateMap as CreateMapCommand;

use IdeaMap\MapRepository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MapSpec extends ObjectBehavior
{
    function let(MapRepository $repository, CreateMapProcess $process)
    {
        $this->beConstructedWith($repository, $process);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\Service\Map');
    }

    function it_creates_a_new_map_with_the_given_name($process)
    {
        $name = 'New map';
        $cmd = new CreateMapCommand(array('name' => $name));
        $process->execute($cmd)->shouldBeCalled()->willReturn(1);

        $this->create($name)->shouldReturn(1);
    }

    function it_gets_the_event_list_for_a_map($repository)
    {
        $id = 1;
        $list = array(new CreateMapCommand(array('name' => 'New map')));
        $repository->eventList($id)->shouldBeCalled()->willReturn($list);

        $this->eventList($id)->shouldReturn($list);
    }
}
