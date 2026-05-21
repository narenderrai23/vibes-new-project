<?php

namespace Livewire\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Title
{
    public function __construct(public string $title = '') {}
}
