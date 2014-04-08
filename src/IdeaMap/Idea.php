<?php

namespace IdeaMap;

class Idea implements \JsonSerializable
{
    protected $id;

    protected $title;

    protected $children;

    public function __construct($id, $title, array $children)
    {
        $this->id = $id;
        $this->title = $title;
        $this->children = $children;
    }

    // should this really be in the IdeaMap namespace?
    public function jsonSerialize()
    {
        return (object) array(
            'id' => $this->id,
            'title' => $this->title,
            'ideas' => $this->children
        );
    }

    public function addChild(Idea $child)
    {
        $this->children[] = $child;
    }

    public function updateTitle($newTitle)
    {
        $this->title = $newTitle;
    }

    public function find($id)
    {
        if ($this->id === $id) {
            return $this;
        }

        foreach ($this->children as $child) {
            $found = $child->find($id);
            if ($found !== null) {
                return $found;
            }
        }

        return null;
    }
}
