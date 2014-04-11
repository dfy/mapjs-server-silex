<?php

namespace spec\IdeaMapApp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use SimpleCommand\CommandList;
use SimpleCommand\CommandDispatcher;
use SimpleCommand\EventPublisher;
use IdeaMap\Command\CreateMap;

class CommandProcessorSpec extends ObjectBehavior
{
    function let(
        CommandList $commandList,
        CommandDispatcher $commandDispatcher,
        EventPublisher $eventPublisher
    ) {
        $this->beConstructedWith($commandList, $commandDispatcher, $eventPublisher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('IdeaMapApp\CommandProcessor');
    }

    function it_passes_commands_to_the_command_dispatcher($commandList, $commandDispatcher)
    {
        $cmd = new CreateMap('A new map');
        $commandList->fetchNext()->willReturn($cmd);
        $commandDispatcher->dispatch($cmd)->shouldBeCalled();

        $this->run();
    }

    function it_passes_commands_to_the_event_publisher_if_there_are_no_errors($commandList, $commandDispatcher, $eventPublisher)
    {
        $cmd = new CreateMap('A new map');
        $commandList->fetchNext()->willReturn($cmd);
        $commandDispatcher->dispatch($cmd)->shouldBeCalled();
        $eventPublisher->publish($cmd)->shouldBeCalled();

        $this->run();
    }

    /*function it_commits_a_command_if_there_are_no_errors($commandList, $commandDispatcher)
    {
        $cmd = new CreateMap('A new map');
        $commandList->fetchNext()->willReturn($cmd);
        $commandDispatcher->dispatch($cmd)->shouldBeCalled();
        $commandList->commitNext()->shouldBeCalled();

        $this->run();
    }*/
}
