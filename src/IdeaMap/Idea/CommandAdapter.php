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
        // TODO: search for parent rather than just adding to root
        $this->rootIdea->addChild(
            new IdeaMapIdea($cmd->getId(), $cmd->getTitle(), [])
        );
    }

    public function jsonSerialize()
    {
        return $this->rootIdea->jsonSerialize();
    }
}
