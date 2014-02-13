<?php

namespace SimpleCommand;

interface CommandSerializer
{
    /**
     *  @param string $data
     *  @return SimpleCommand\Command
     */
    public function unserialize($data);
}