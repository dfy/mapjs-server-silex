<?php

namespace IdeaMap;

class Map
{
    public function __construct($name, $id = null)
    {
        if (!is_string($name) || strlen(trim($name)) === 0) {
            throw new InvalidArgumentException('Invalid "name" argument');
        }
    }
}
