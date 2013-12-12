<?php

namespace IdeaMap\Predis;

use IdeaMap\MapRepository as MapRepositoryInterface;
use IdeaMap\Command\CreateMap;

class MapRepository implements MapRepositoryInterface
{
    const MAP_COUNT_KEY = 'ideamap:count:map';

    /**
     *  @var IdeaMap\Predis\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(CreateMap $cmd)
    {
        $mapId = $this->client->incr(self::MAP_COUNT_KEY);

        return $mapId;
    }
}
