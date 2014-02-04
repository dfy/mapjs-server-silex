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
    public function __construct(array $values)
    {
        if (isset($values['title'])) {
            $this->title = $values['title'];
        } else {
            throw new \InvalidArgumentException('Title not found in values');
        }
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
