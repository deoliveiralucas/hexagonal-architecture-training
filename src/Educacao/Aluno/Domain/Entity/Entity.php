<?php

namespace Acruxx\Educacao\Aluno\Domain\Entity;

abstract class Entity
{

    /** @var array */
    private $events;

    public function raise($event) : void
    {
        $this->events[] = $event;
    }

    public function releaseEvents() : array
    {
        $events = $this->events;
        $this->events = [];
        return (array)$events;
    }
}
