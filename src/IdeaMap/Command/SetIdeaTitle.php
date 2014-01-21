<?php

namespace IdeaMap\Command;

class SetIdeaTitle
{
    protected $id;

    protected $title;

    public function __construct(array $values)
    {
        if (!isset($values['id'])) {
            throw new \InvalidArgumentException('ID not found in values');
        }
        if (!isset($values['title'])) {
            throw new \InvalidArgumentException('Title not found in values');
        }

        $this->id = $values['id'];
        $this->title = $values['title'];
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
