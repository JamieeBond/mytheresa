<?php

namespace App\CQRS;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * QueryBus abstraction of symfony messenger.
 * Layer between application code and symfony component.
 */
class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    /**
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /** @return mixed */
    public function handle(Query $query)
    {
        return $this->handleQuery($query);
    }
}
