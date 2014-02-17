<?php

namespace IdeaMap;

use IdeaMap\Command\CreateMap;

interface MapRepository
{
    public function create(CreateMap $cmd);

    public function eventList($id);

    public function append($mapId, $cmd);

    public function getNextCommand($mapId);

    public function commitNextCommand($mapId);
}
