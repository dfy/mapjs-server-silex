<?php

namespace spec\IdeaMap\Predis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use IdeaMap\Predis\Client;
use IdeaMap\Command\CreateMap;

class MapRepositorySpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
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
        $client->lpush('ideamap:map1:incoming', $cmdJson)->shouldBeCalled();

        $this->create($cmd);
    }
}
