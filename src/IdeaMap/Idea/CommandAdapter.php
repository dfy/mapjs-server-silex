<?php

namespace IdeaMap\Idea;

use IdeaMap\Idea as IdeaMapIdea;
use IdeaMap\Command\AddSubIdea;
use IdeaMap\Command\SetIdeaTitle;

class CommandAdapter implements \JsonSerializable
{
    private $rootIdea;

    public function __construct(IdeaMapIdea $rootIdea)
    {
        $this->rootIdea = $rootIdea;
    }

    public function addSubIdea(AddSubIdea $cmd)
    {
        $parentIdea = $this->getIdea($cmd->getParentId());

        $parentIdea->addChild(
            new IdeaMapIdea($cmd->getId(), $cmd->getTitle(), [])
        );
    }

    public function setIdeaTitle(SetIdeaTitle $cmd)
    {
        $this->getIdea($cmd->getId())
            ->updateTitle($cmd->getTitle());
    }

    public function jsonSerialize()
    {
        return $this->rootIdea->jsonSerialize();
    }

    /**
     * @param int $id
     * @return IdeaMap\Idea|null
     * @throws \InvalidArgumentException
     */
    private function getIdea($id)
    {
        $idea = $this->rootIdea->find($id);

        if (!$idea) {
            throw new \InvalidArgumentException("Idea not found with ID $id");
        }

        return $idea;
    }
}
