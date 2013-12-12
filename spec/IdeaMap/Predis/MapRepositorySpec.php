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

    function it_should_save_a_new_map(Client $client, CreateMap $cmd)
    {
        $client->incr('ideamap:count:map')->shouldBeCalled()->willReturn(1);
        //$client->incr('ideamap:count:map')->shouldBeCalled()->willReturn(1);

        $this->create($cmd);
    }

    // $user_id = $redis->incr('user:id');
    // $client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
}
