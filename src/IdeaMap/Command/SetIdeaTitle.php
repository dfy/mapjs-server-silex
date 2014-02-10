<?php

namespace IdeaMap\Command;

class SetIdeaTitle
{
    protected $id;

    protected $title;

    public function __construct($id, $title)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('Invalid ID parameter');
        }
        if (!is_string($title)) {
            throw new \InvalidArgumentException('Invalid title parameter');
        }

        $this->id = $id;
        $this->title = $title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
