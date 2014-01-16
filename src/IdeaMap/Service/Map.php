<?php

namespace IdeaMap\Service;

use IdeaMap\Process\CreateMap as CreateMapProcess;
use IdeaMap\Command\CreateMap as CreateMapCommand;
use IdeaMap\MapRepository;

class Map
{
    /**
     * @var MapRepository
     */
    protected $repository;

    /**
     * @var CreateMapProcess
     */
    protected $process;

    public function __construct(MapRepository $repository, CreateMapProcess $process)
    {
        $this->repository = $repository;
        $this->process = $process;
    }

    public function create($name)
    {
        $cmd = new CreateMapCommand(array('name' => $name));
        return $this->process->execute($cmd);
    }

    public function eventList($id)
    {
        return $this->repository->eventList($id);
    }
}
