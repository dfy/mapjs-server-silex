<?php

namespace IdeaMap\Predis;

use Predis\Client as PredisClient;

class Client
{
    protected $predisClient;

    public function __construct(PredisClient $predisClient)
    {
        $this->predisClient = $predisClient;
    }

    public function incr($key)
    {
        $this->predisClient->incr($key);
    }

    public function lpush($key, $value)
    {
        $this->predisClient->lpush($key, $value);
    }

    public function rpush($key, $value)
    {
        $this->predisClient->rpush($key, $value);
    }
}
