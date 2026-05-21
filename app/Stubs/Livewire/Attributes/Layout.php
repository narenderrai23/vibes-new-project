<?php

namespace Livewire\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Layout
{
    public function __construct(public string $name = '') {}
}
