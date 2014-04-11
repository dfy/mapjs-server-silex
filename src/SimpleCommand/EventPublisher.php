<?php

namespace SimpleCommand;

interface EventPublisher
{
    public function publish($event);
}
