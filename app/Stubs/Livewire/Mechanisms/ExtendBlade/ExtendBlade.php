<?php

namespace Livewire\Mechanisms\ExtendBlade;

/**
 * Livewire ExtendBlade compatibility stub.
 * Satisfies any remaining compiled view references after livewire/livewire removal.
 */
class ExtendBlade
{
    public function __call(string $method, array $args): mixed
    {
        return null;
    }

    public static function __callStatic(string $method, array $args): mixed
    {
        return null;
    }
}
