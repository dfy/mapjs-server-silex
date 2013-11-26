<?php

namespace IdeaMap\Predis;

use IdeaMap\Map;
use IdeaMap\MapRepository as MapRepositoryInterface;
use Predis\Client;

class MapRepository implements MapRepositoryInterface
{
    /**
     *  @var Predis\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function save(Map $map)
    {

    }
}
