<?php

namespace IdeaMap\Service;

use IdeaMap\Process\CreateMap as CreateMapProcess;
use IdeaMap\Command\CreateMap as CreateMapCommand;
use IdeaMap\MapRepository;
use IdeaMap\CommandSerializer;

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

    /**
     * @var CommandSerializer
     */
    protected $serializer;

    public function __construct(MapRepository $repository, CreateMapProcess $process, CommandSerializer $serializer)
    {
        $this->repository = $repository;
        $this->process = $process;
        $this->serializer = $serializer;
    }

    public function create($name)
    {
        $cmd = new CreateMapCommand($name);
        return $this->process->execute($cmd);
    }

    public function eventList($id)
    {
        return $this->repository->eventList($id);
    }

    public function append($data)
    {
        $cmd = $this->serializer->jsonDecode($data);

        return $this->repository->append(
            $this->serializer->jsonDecode($data)
        );
    }
}
