<?php

namespace SimpleCommand;

interface CommandSerializer
{
    /**
     *  @param string $json
     *  @return SimpleCommand\Command
     */
    public function jsonDecode($json);
}