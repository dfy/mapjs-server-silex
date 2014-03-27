<?php

namespace SimpleCommand;

interface CommandSerializer
{
    /**
     *  @param string $data
     *  @return object
     */
    public function unserialize($data);

    public function serialize($command);
}