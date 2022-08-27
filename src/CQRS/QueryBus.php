<?php

namespace App\CQRS;

interface QueryBus
{
    /** @return mixed */
    public function handle(Query $query);
}
