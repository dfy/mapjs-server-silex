<?php

namespace SimpleCommand;

/**
 * Feels like a bit of the implementation is present in this interface... if
 * we rely on redis to move commands between lists commitNext is necessary -
 * rather than, e.g. commit($cmd). So maybe this shouldn't be in SimpleCommand
 *
 * @package SimpleCommand
 */
interface CommandList
{
    public function fetchNext();

    public function commitNext();
}