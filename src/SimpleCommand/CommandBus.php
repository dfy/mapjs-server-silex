<?php

namespace SimpleCommand;

interface CommandBus
{
    public function storeIncoming($command);

    public function notify($command);
}