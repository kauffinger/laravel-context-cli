<?php

namespace Kauffinger\Context\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kauffinger\Context\Context
 */
class Context extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kauffinger\Context\Context::class;
    }
}
