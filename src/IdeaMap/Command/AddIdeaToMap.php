<?php

namespace IdeaMap\Command;

class AddIdeaToMap implements \JsonSerializable
{
    const TYPE = 'AddIdeaToMap';

    protected $id;

    protected $parentId;

    public function __construct($id, $parentId=null)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('Invalid ID parameter');
        }
        if (!is_int($parentId) && !is_null($parentId)) {
            throw new \InvalidArgumentException('Invalid parent ID parameter');
        }

        $this->id = $id;
        $this->parentId = $parentId;
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
