<?php
/**
 */

namespace IdeaMap\Command;

/**
 *  Command for creating a new map
 */
class CreateMap extends Command
{
    const TYPE = 'CreateMap';

    /**
     *  @var string
     */
    private $name;

    /**
     *  @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['name'])) {
            $this->name = $values['name'];
        } else {
            throw new \InvalidArgumentException('Name not found in values');
        }
    }

    /**
     *  @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *  @return string
     */
    public function toJson()
    {
        return json_encode(
            (object) array('type' => 'CreateMap', 'name' => $this->name)
        );
    }
}
