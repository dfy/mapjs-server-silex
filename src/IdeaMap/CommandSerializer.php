<?php

namespace IdeaMap;

use SimpleCommand\CommandSerializer as CommandSerializerInterface;

class CommandSerializer implements CommandSerializerInterface
{
    /**
     *  @param string $json
     *  @return IdeaMap\Command\Command
     */
    public function jsonDecode($json)
    {
        $o = json_decode($json);
        if (!is_object($o)) {
            throw new \InvalidArgumentException('Could not decode json string to object');
        }

        if (!isset($o->type)) {
            throw new \InvalidArgumentException('Command type not given');
        }

        $className = 'IdeaMap\\Command\\' . $o->type;
        if (!class_exists($className)) {
            throw new \InvalidArgumentException('Invalid command type given');
        }

        unset($o->type);

        return new $className((array) $o);
    }
}
