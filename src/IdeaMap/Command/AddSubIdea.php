<?php

namespace IdeaMap\Command;

use IdeaMap\Command as IdeaMapCommand;

class AddSubIdea implements IdeaMapCommand
{
    const TYPE = 'AddSubIdea';

    protected $id;

    protected $parentId;

    public function __construct($id, $title, $parentId=null)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('Invalid ID parameter');
        }
        if (!is_string($title)) {
            throw new \InvalidArgumentException('Invalid title parameter');
        }
        if (!is_int($parentId) && !is_null($parentId)) {
            throw new \InvalidArgumentException('Invalid parent ID parameter');
        }

        $this->id = $id;
        $this->title = $title;
        $this->parentId = $parentId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function jsonSerialize()
    {
        return (object) array(
            'type' => self::TYPE,
            'id' => $this->id,
            'title' => $this->title,
            'parentId' => $this->parentId
        );
    }
}
