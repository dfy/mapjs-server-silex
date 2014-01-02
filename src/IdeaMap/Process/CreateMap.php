<?php

namespace IdeaMap\Process;

use SimpleCommand\CommandProcess;
use IdeaMap\Command\Command;
use IdeaMap\Command\CreateMap as CreateMapCommand;
use IdeaMap\MapRepository;

class CreateMap implements CommandProcess
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    // shouldn't I be able to use CreateMapCommand as the param type?
    public function execute(Command $cmd)
    {
        if (!$cmd instanceof CreateMapCommand) {
            throw new \InvalidArgumentException('Can only create on a CreateMap command');
        }

        return $this->repository->create($cmd);
    }
}
