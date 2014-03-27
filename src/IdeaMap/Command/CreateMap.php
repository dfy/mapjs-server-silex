<?php
/**
 */

namespace IdeaMap\Command;

use IdeaMap\Command as IdeaMapCommand;

/**
 *  Command for creating a new map
 */
class CreateMap implements IdeaMapCommand
{
    const TYPE = 'CreateMap';

    /**
     *  @var string
     */
    private $title;

    /**
     *  @param array $values
     */
    public function __construct($title)
    {
        if (!is_string($title)) {
            throw new \InvalidArgumentException('Invalid title parameter');
        }

        $this->title = $title;
    }

    /**
     *  @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *  @return object
     */
    public function jsonSerialize()
    {
        return (object) array('type' => 'CreateMap', 'title' => $this->title);
    }
}
