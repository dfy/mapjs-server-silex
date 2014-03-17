<?php
/**
 */

namespace IdeaMapApp;

/**
 */
class Map
{
    /**
     *  @param string $name
     *  @param int $id optional
     */
    public function __construct($name, $id = null)
    {
        if (!is_string($name) || strlen(trim($name)) === 0) {
            throw new InvalidArgumentException('Invalid "name" argument');
        }
    }
}
