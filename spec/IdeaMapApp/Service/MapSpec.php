<?php

namespace spec\IdeaMapApp\Service;

use IdeaMapApp\Process\CreateMap as CreateMapProcess;
use IdeaMap\Command\CreateMap as CreateMapCommand;
use IdeaMap\Command\AddSubIdea as AddSubIdeaCommand;

use IdeaMapApp\MapRepository;
use IdeaMapApp\CommandSerializer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MapSpec extends ObjectBehavior
{
    function let(MapRepository $repository, CreateMapProcess $process)
    {
        $serializer = new CommandSerializer();
        $this->beConstructedWith($repository, $process, $serializer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMapApp\Service\Map');
    }

    function it_creates_a_new_map_with_the_given_title($process)
    {
        $title = 'New map';
        $cmd = new CreateMapCommand($title);
        $process->execute($cmd)->shouldBeCalled()->willReturn(1);

        $this->create($title)->shouldReturn(1);
    }

    function it_gets_the_event_list_for_a_map($repository)
    {
        $id = 1;
        $list = array(new CreateMapCommand('New map'));
        $repository->eventList($id)->shouldBeCalled()->willReturn($list);

        $this->eventList($id)->shouldReturn($list);
    }

    function it_appends_a_single_command($repository)
    {
        $mapId = 1;
        $cmd = new AddSubIdeaCommand(2, 'Idea title', 1);
        $repository->append($mapId, $cmd)->shouldBeCalled();

        $this->append($mapId, json_encode($cmd));
    }
}
