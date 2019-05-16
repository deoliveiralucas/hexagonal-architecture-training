<?php

namespace Acruxx\Educacao\Aluno\Infrastructure\Event;

use Acruxx\Educacao\Aluno\Domain\Event\Dispatcher;
use Acruxx\Educacao\Aluno\Domain\Listener\Listener;

class AcruxxDispatcher implements Dispatcher
{

    /** @var Listener[] */
    private $listeners;

    public function attach(string $eventName, Listener $listener) : void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(array $events) : void
    {
        foreach ($events as $event) {
            $this->handleEvent($event);
        }
    }

    private function handleEvent($event) : void
    {
        $eventName = get_class($event);
        
        if (! isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $eventListener) {
            $eventListener->handle($event);
        }
    }
}
