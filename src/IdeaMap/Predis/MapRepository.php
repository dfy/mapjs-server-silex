<?php

namespace IdeaMap\Predis;

use IdeaMap\MapRepository as MapRepositoryInterface;
use IdeaMap\Command\CreateMap;
use SimpleCommand\CommandSerializer;

class MapRepository implements MapRepositoryInterface
{
    const MAP_COUNT_KEY = 'ideamap:count:map';

    const MAP_INCOMING_KEY = 'ideamap:map%d:incoming';

    const MAP_PROCESSED_KEY = 'ideamap:map%d:processed';

    /**
     *  @var IdeaMap\Predis\Client
     */
    protected $client;

    protected $serializer;

    /**
     *  @param IdeaMap\Predis\Client $client
     *  @param SimpleCommand\CommandSerializer $serializer
     */
    public function __construct(Client $client, CommandSerializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
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
            $this->serializer->serialize($cmd)
        );

        return $mapId;
    }

    public function eventList($mapId)
    {
        $rawData = $this->client->lrange(
            sprintf(self::MAP_PROCESSED_KEY, $mapId),
            0,
            99999
        );

        $cmds = array();
        foreach ($rawData as $rawDatum) {
            $cmds[] = $this->serializer->unserialize($rawDatum);
        }

        return $cmds;
    }

    public function append($mapId, $cmd)
    {
        $this->client->rpush(
            sprintf(self::MAP_INCOMING_KEY, $mapId),
            $this->serializer->serialize($cmd)
        );
    }

    public function getNextCommand($mapId)
    {
        $rawData = $this->client->lindex(
            sprintf(self::MAP_INCOMING_KEY, $mapId),
            -1
        );

        if (is_array($rawData) && isset($rawData[0])) {
            return $this->serializer->unserialize($rawData[0]);
        } else {
            return null;
        }
    }
}
