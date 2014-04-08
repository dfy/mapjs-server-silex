<?php

namespace IdeaMap\Idea;

use IdeaMap\Idea as IdeaMapIdea;
use IdeaMap\Command\AddSubIdea;

class CommandAdapter
{
    private $rootIdea;

    public function __construct(IdeaMapIdea $rootIdea)
    {
        $this->rootIdea = $rootIdea;
    }

    public function addSubIdea(AddSubIdea $cmd)
    {
        // TODO: maybe extract this logic to a finder
        $parentId = $cmd->getParentId();
        $parentIdea = $this->rootIdea->find($parentId);

        if (!$parentIdea) {
            throw new \InvalidArgumentException("Parent not found with ID $parentId");
        }

        $parentIdea->addChild(
            new IdeaMapIdea($cmd->getId(), $cmd->getTitle(), [])
        );
    }

    public function jsonSerialize()
    {
        return $this->rootIdea->jsonSerialize();
    }
}
