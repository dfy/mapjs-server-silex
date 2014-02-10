<?php
/**
 */

namespace IdeaMap\Command;

use SimpleCommand\Command;

/**
 *  Command for creating a new map
 */
class CreateMap implements Command
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
     *  @return string
     */
    public function toJson()
    {
        return json_encode(
            (object) array('type' => 'CreateMap', 'title' => $this->title)
        );
    }
}
