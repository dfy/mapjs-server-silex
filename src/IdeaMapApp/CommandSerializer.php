<?php

namespace IdeaMapApp;

use SimpleCommand\CommandSerializer as CommandSerializerInterface;
use SimpleCommand\Command as CommandInterface;

class CommandSerializer implements CommandSerializerInterface
{
    /**
     *  @param string $data
     *  @return IdeaMapApp\Command\Command
     */
    public function unserialize($data)
    {
        $o = json_decode($data);
        if (!is_object($o)) {
            throw new \InvalidArgumentException('Could not decode json string to object');
        }

        if (!isset($o->type)) {
            throw new \InvalidArgumentException('Command type not given');
        }

        $className = 'IdeaMapApp\\Command\\' . $o->type;
        if (!class_exists($className)) {
            throw new \InvalidArgumentException('Invalid command type given');
        }

        // TODO: replace with something more flexible...
        switch ($o->type) {
            case 'CreateMap':
                $cmd = new $className($o->title);
                break;

            case 'AddSubIdea':
                $cmd = new $className($o->id, $o->title, $o->parentId);
                break;

            default:
                throw new \RuntimeException("Type {$o->type} could not be decoded");
        }

        return $cmd;
    }

    public function serialize(CommandInterface $command)
    {
        // maybe Command::getSerializableData() and a trait to do the json bit - ?
        return json_encode($command);
    }
}
