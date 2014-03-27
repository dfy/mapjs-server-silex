<?php

namespace spec\IdeaMapApp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandSerializerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SimpleCommand\CommandSerializer');
    }

    function it_should_create_a_command_based_on_the_given_type_string()
    {
        $title = 'Test map';
        $json = json_encode(array('type' => 'CreateMap', 'title' => $title));
        $cmd = new \IdeaMap\Command\CreateMap($title);

        $this->unserialize($json)->shouldBeLike($cmd);
    }

    function it_should_not_create_a_command_if_the_given_data_is_invalid()
    {
        $ex = new \InvalidArgumentException('Could not decode json string to object');

        $this->shouldThrow($ex)->duringUnserialize('not json');
    }

    function it_should_not_create_a_command_if_there_is_no_type()
    {
        $json = json_encode(array('title' => 'Name'));
        $ex = new \InvalidArgumentException('Command type not given');

        $this->shouldThrow($ex)->duringUnserialize($json);
    }

    function it_should_not_create_a_command_if_the_type_does_not_match_a_command()
    {
        $json = json_encode(array('type' => 'InvalidCommand'));
        $ex = new \InvalidArgumentException('Invalid command type given');

        $this->shouldThrow($ex)->duringUnserialize($json);
    }

    function it_should_decode_an_add_subidea_command()
    {
        $data = array(
            'type' => 'AddSubIdea',
            'id' => 2,
            'title' => 'New sub-idea',
            'parentId' => 1
        );
        $json = json_encode($data);
        $cmd = new \IdeaMap\Command\AddSubIdea(
            $data['id'],
            $data['title'],
            $data['parentId']
        );

        $this->unserialize($json)->shouldBeLike($cmd);
    }

    // it should not create a command if there is no type
    // it should not create a command if the type does not match a command
}
