<?php

namespace IdeaMap\Service;

use IdeaMap\Process\CreateMap as CreateMapProcess;
use IdeaMap\Command\CreateMap as CreateMapCommand;

class Map
{
    /**
     * @var CreateMapProcess
     */
    protected $process;

    public function __construct(CreateMapProcess $process)
    {
        $this->process = $process;
    }

    public function create($name)
    {
        $cmd = new CreateMapCommand(array('name' => $name));
        return $this->process->execute($cmd);
    }
}
