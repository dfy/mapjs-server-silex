<?php

namespace spec\IdeaMapApp\Process;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use IdeaMapApp\MapRepository;
use SimpleCommand\Command;
use IdeaMap\Command\CreateMap as CreateMapCommand;

class CreateMapSpec extends ObjectBehavior
{
    function let(MapRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMapApp\Process\CreateMap');
    }

    function it_saves_a_new_map(CreateMapCommand $cmd, $repository)
    {
        $repository->create($cmd)->shouldBeCalled()->willReturn(1);

        $this->execute($cmd)->shouldEqual(1);
    }

    function it_does_not_save_anything_else(Command $cmd)
    {
        $ex = new \InvalidArgumentException('Can only create on a CreateMap command');
        $this->shouldThrow($ex)->duringExecute($cmd);
    }
}
