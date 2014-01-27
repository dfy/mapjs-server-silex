<?php

namespace IdeaMap\Command;

class AddIdeaToMap implements \JsonSerializable
{
    const TYPE = 'AddIdeaToMap';

    protected $id;

    protected $parentId;

    public function __construct(array $values)
    {
        if (!array_key_exists('id', $values) || is_null($values['id'])) {
            throw new \InvalidArgumentException('ID not found in values');
        }
        if (!array_key_exists('parentId', $values)) {
            throw new \InvalidArgumentException('Parent ID not found in values');
        }

        $this->id = $values['id'];
        $this->parentId = $values['parentId'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function toJson()
    {
        return json_encode(
            (object) array('type' => self::TYPE, 'id' => $this->id, 'parentId' => $this->parentId)
        );
    }

    public function jsonSerialize()
    {
        return $this->toJson();
    }
}
