<?php

namespace IdeaMap;

use IdeaMap\Command\CreateMap;

interface MapRepository
{
    public function create(CreateMap $cmd);

    public function eventList($id);
}
