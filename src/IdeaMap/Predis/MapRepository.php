<?php

namespace IdeaMap\Predis;

use IdeaMap\MapRepository as MapRepositoryInterface;
use IdeaMap\Command\CreateMap;

class MapRepository implements MapRepositoryInterface
{
    const MAP_COUNT_KEY = 'ideamap:count:map';

    const MAP_INCOMING_KEY = 'ideamap:map%d:incoming';

    const MAP_PROCESSED_KEY = 'ideamap:map%d:processed';

    /**
     *  @var IdeaMap\Predis\Client
     */
    protected $client;

    /**
     *  @param IdeaMap\Predis\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     *  @param IdeaMap\Command\CreateMap $cmd
     *  @return integer
     */
    public function create(CreateMap $cmd)
    {
        $mapId = $this->client->incr(self::MAP_COUNT_KEY);
        $this->client->rpush(
            sprintf(self::MAP_PROCESSED_KEY, $mapId),
            $cmd->toJson()
        );

        return $mapId;
    }
}
