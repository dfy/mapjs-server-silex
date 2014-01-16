<?php

namespace spec\IdeaMap\Predis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use IdeaMap\Predis\Client;
use IdeaMap\Command\CreateMap;
use IdeaMap\CommandSerializer;

class MapRepositorySpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client, new CommandSerializer());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMap\Predis\MapRepository');
    }

    function it_should_save_a_new_map(Client $client)
    {
        $cmdData = array('type' => 'CreateMap', 'name' => 'Test map');
        $cmdJson = json_encode((object) $cmdData);

        unset($cmdData['type']);
        $cmd = new CreateMap($cmdData);

        $client->incr('ideamap:count:map')->shouldBeCalled()->willReturn(1);
        $client->rpush('ideamap:map1:processed', $cmdJson)->shouldBeCalled();

        $this->create($cmd);
    }

    function it_gets_the_event_list_for_a_map($client)
    {
        $cmdName = 'Test map';
        $cmdData = array('type' => 'CreateMap', 'name' => $cmdName);
        $cmdJson = json_encode((object) $cmdData);
        $cmdObj = new CreateMap(array('name' => $cmdName));

        $client->lrange('ideamap:map1:processed', 0, 99999)
            ->shouldBeCalled()
            ->willReturn(array($cmdJson));

        $list = $this->eventList(1)->getWrappedObject();

        if ($list != array($cmdObj)) {
            throw new \RuntimeException('Returned list does not match expected list');
        }
    }
}
